param(
    [string]$Php = "php",
    [string]$Composer = "composer"
)

& $Composer install --no-dev --optimize-autoloader
& $Php bin/console doctrine:migrations:migrate --no-interaction --env=prod
& $Php bin/console cache:clear --env=prod --no-debug
& $Php bin/console cache:warmup --env=prod --no-debug
