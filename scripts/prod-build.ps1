param(
    [string]$Php = "php",
    [string]$Composer = "composer"
)

$ErrorActionPreference = "Stop"
$env:APP_ENV = "prod"
$env:APP_DEBUG = "0"

Push-Location (Join-Path $PSScriptRoot "..")
try {
    & $Composer install --no-dev --optimize-autoloader --no-interaction
    if ($LASTEXITCODE -ne 0) { throw "Installation Composer echouee." }

    & $Php bin/console doctrine:query:sql "SELECT 1" --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Connexion impossible. Verifiez DATABASE_URL sur le serveur." }

    & $Php bin/console doctrine:migrations:migrate --no-interaction --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Migration echouee." }

    & $Php bin/console lint:twig templates --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Validation Twig echouee." }

    & $Php bin/console lint:yaml translations config --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Validation YAML echouee." }

    & $Php bin/console cache:clear --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Nettoyage du cache echoue." }

    & $Php bin/console cache:warmup --env=prod --no-debug
    if ($LASTEXITCODE -ne 0) { throw "Preparation du cache echouee." }
} finally {
    Pop-Location
}
