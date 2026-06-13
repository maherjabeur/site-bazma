#!/usr/bin/env sh
set -eu

APP_PORT="${PORT:-10000}"

echo "Listen ${APP_PORT}" > /etc/apache2/ports.conf
sed "s/__PORT__/${APP_PORT}/g" /etc/apache2/sites-available/000-default.conf.template > /etc/apache2/sites-available/000-default.conf

if [ -n "${DB_HOST:-}" ]; then
    DB_PORT="${DB_PORT:-3306}"
    DB_NAME="${DB_NAME:-bazma}"
    DB_USER="${DB_USER:-bazma}"
    DB_PASSWORD_ENCODED="$(php -r 'echo rawurlencode(getenv("DB_PASSWORD") ?: "");')"
    export DATABASE_URL="mysql://${DB_USER}:${DB_PASSWORD_ENCODED}@${DB_HOST}:${DB_PORT}/${DB_NAME}?serverVersion=${DB_SERVER_VERSION:-8.4.7}&charset=utf8mb4"
fi

mkdir -p var/cache var/log var/editor-video-chunks public/uploads
chown -R www-data:www-data var public/uploads

if [ -n "${DB_HOST:-}" ]; then
    echo "Waiting for database ${DB_HOST}:${DB_PORT:-3306}..."
    ATTEMPTS=0
    until mysqladmin ping -h"${DB_HOST}" -P"${DB_PORT:-3306}" -u"${DB_USER:-bazma}" -p"${DB_PASSWORD:-}" --silent; do
        ATTEMPTS=$((ATTEMPTS + 1))
        if [ "$ATTEMPTS" -ge 60 ]; then
            echo "Database is not reachable after 60 attempts."
            exit 1
        fi
        sleep 2
    done
fi

if [ "${RUN_MIGRATIONS:-0}" = "1" ]; then
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
fi

php bin/console cache:clear --env=prod --no-debug --no-warmup
php bin/console cache:warmup --env=prod --no-debug
chown -R www-data:www-data var public/uploads

exec "$@"
