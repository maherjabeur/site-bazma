param(
    [string]$DbHost = "127.0.0.1",
    [int]$DbPort = 3306,
    [string]$DbName = "bazma",
    [string]$DbUser = "root",
    [string]$DbPassword = "",
    [string]$Mysql = "mysql",
    [switch]$SkipCache
)

$ErrorActionPreference = "Stop"
$projectDir = Resolve-Path (Join-Path $PSScriptRoot "..")
$dumpPath = Join-Path $projectDir "bazma.sql"

if (-not (Test-Path $dumpPath)) {
    throw "Dump SQL introuvable: $dumpPath"
}

if ($DbName -notmatch '^[A-Za-z0-9_]+$') {
    throw "Nom de base invalide: $DbName"
}

function Invoke-Mysql {
    param(
        [string]$Sql,
        [string]$InputFile
    )

    $args = @(
        "--host=$DbHost",
        "--port=$DbPort",
        "--user=$DbUser",
        "--default-character-set=utf8mb4"
    )

    if ($DbPassword -ne "") {
        $args += "--password=$DbPassword"
    }

    if ($Sql) {
        $Sql | & $Mysql @args
    } elseif ($InputFile) {
        Get-Content -Raw -Encoding UTF8 $InputFile | & $Mysql @args $DbName
    }

    if ($LASTEXITCODE -ne 0) {
        throw "Commande MySQL echouee."
    }
}

Write-Host "Reinitialisation de la base locale '$DbName' sur ${DbHost}:$DbPort..."
Invoke-Mysql -Sql "DROP DATABASE IF EXISTS $DbName; CREATE DATABASE $DbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

Write-Host "Import du dump bazma.sql..."
Invoke-Mysql -InputFile $dumpPath

$env:APP_ENV = "prod"
$env:APP_DEBUG = "0"
$env:DATABASE_URL = "mysql://$DbUser@$DbHost`:$DbPort/$DbName`?serverVersion=8.4.7&charset=utf8mb4"
if ($DbPassword -ne "") {
    $encodedPassword = [uri]::EscapeDataString($DbPassword)
    $env:DATABASE_URL = "mysql://$DbUser`:$encodedPassword@$DbHost`:$DbPort/$DbName`?serverVersion=8.4.7&charset=utf8mb4"
}

Write-Host "Mise a jour du schema avec les migrations Doctrine..."
& php bin/console doctrine:migrations:migrate --no-interaction --env=prod --no-debug
if ($LASTEXITCODE -ne 0) { throw "doctrine:migrations:migrate a echoue." }

if (-not $SkipCache) {
    Write-Host "Preparation du cache Symfony prod..."
    & php bin/console cache:clear --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "cache:clear a echoue." }

    & php bin/console cache:warmup --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "cache:warmup a echoue." }
}

Write-Host ""
Write-Host "Demo locale prete."
Write-Host "Lancer ensuite:"
Write-Host "  php -S localhost:8000 -t public"
Write-Host "Ouvrir:"
Write-Host "  http://localhost:8000/fr"
Write-Host "  http://127.0.0.1:8000/fr"
