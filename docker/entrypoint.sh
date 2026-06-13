#!/usr/bin/env sh
set -eu

APP_PORT="${PORT:-10000}"

echo "Listen ${APP_PORT}" > /etc/apache2/ports.conf
sed "s/__PORT__/${APP_PORT}/g" /etc/apache2/sites-available/000-default.conf.template > /etc/apache2/sites-available/000-default.conf

mkdir -p var/cache var/log var/editor-video-chunks public/uploads
chown -R www-data:www-data var public/uploads

if [ "${RUN_MIGRATIONS:-0}" = "1" ]; then
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
fi

php bin/console cache:clear --env=prod --no-debug --no-warmup
php bin/console cache:warmup --env=prod --no-debug
chown -R www-data:www-data var public/uploads

exec "$@"
