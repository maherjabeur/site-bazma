#!/usr/bin/env sh
set -eu

APP_PORT="${PORT:-10000}"

echo "Listen ${APP_PORT}" > /etc/apache2/ports.conf
sed "s/__PORT__/${APP_PORT}/g" /etc/apache2/sites-available/000-default.conf.template > /etc/apache2/sites-available/000-default.conf

if [ -n "${DB_HOSTPORT:-}" ]; then
    DB_HOST="${DB_HOSTPORT%:*}"
    DB_PORT="${DB_HOSTPORT##*:}"
fi

if [ -n "${DATABASE_URL:-}" ]; then
    case "${DATABASE_URL}" in
        postgres://*|postgresql://*)
            DB_SERVER_VERSION="${DB_SERVER_VERSION:-18.0.0}"
            ;;
        mysql://*|mariadb://*)
            DB_SERVER_VERSION="${DB_SERVER_VERSION:-8.4.7}"
            ;;
    esac
    export DB_SERVER_VERSION
    echo "Using database from DATABASE_URL"
elif [ -n "${DB_HOST:-}" ]; then
    DB_DRIVER="${DB_DRIVER:-mysql}"
    DB_NAME="${DB_NAME:-bazma}"
    DB_USER="${DB_USER:-bazma}"
    DB_PASSWORD_ENCODED="$(php -r 'echo rawurlencode(getenv("DB_PASSWORD") ?: "");')"
    if [ "${DB_DRIVER}" = "postgres" ] || [ "${DB_DRIVER}" = "postgresql" ]; then
        DB_PORT="${DB_PORT:-5432}"
        DB_SERVER_VERSION="${DB_SERVER_VERSION:-18.0.0}"
        export DATABASE_URL="postgresql://${DB_USER}:${DB_PASSWORD_ENCODED}@${DB_HOST}:${DB_PORT}/${DB_NAME}?serverVersion=${DB_SERVER_VERSION}&charset=utf8"
    else
        DB_PORT="${DB_PORT:-3306}"
        DB_SERVER_VERSION="${DB_SERVER_VERSION:-8.4.7}"
        export DATABASE_URL="mysql://${DB_USER}:${DB_PASSWORD_ENCODED}@${DB_HOST}:${DB_PORT}/${DB_NAME}?serverVersion=${DB_SERVER_VERSION}&charset=utf8mb4"
    fi
    export DB_SERVER_VERSION
    echo "Using database ${DB_HOST}:${DB_PORT}/${DB_NAME}"
fi

{
    printf 'SetEnv APP_ENV "%s"\n' "${APP_ENV:-prod}"
    printf 'SetEnv APP_DEBUG "%s"\n' "${APP_DEBUG:-0}"
    printf 'SetEnv APP_SECRET "%s"\n' "${APP_SECRET:-}"
    printf 'SetEnv DEFAULT_URI "%s"\n' "${DEFAULT_URI:-https://www.bazma.tn}"
    printf 'SetEnv DATABASE_URL "%s"\n' "${DATABASE_URL:-}"
    printf 'SetEnv DB_SERVER_VERSION "%s"\n' "${DB_SERVER_VERSION:-}"
} > /etc/apache2/conf-available/app-env.conf
a2enconf app-env >/dev/null

mkdir -p var/cache var/log var/editor-video-chunks public/uploads
chown -R www-data:www-data var public/uploads

if [ -n "${DB_HOST:-}" ] && { [ "${DB_DRIVER:-mysql}" = "postgres" ] || [ "${DB_DRIVER:-mysql}" = "postgresql" ]; }; then
    echo "Waiting for PostgreSQL database ${DB_HOST}:${DB_PORT:-5432}..."
    ATTEMPTS=0
    until PGPASSWORD="${DB_PASSWORD:-}" pg_isready -h "${DB_HOST}" -p "${DB_PORT:-5432}" -U "${DB_USER:-bazma}" -d "${DB_NAME:-bazma}" >/dev/null 2>&1; do
        ATTEMPTS=$((ATTEMPTS + 1))
        if [ "$ATTEMPTS" -ge 60 ]; then
            echo "PostgreSQL database is not reachable after 60 attempts."
            exit 1
        fi
        sleep 2
    done
elif [ -n "${DB_HOST:-}" ]; then
    echo "Waiting for database ${DB_HOST}:${DB_PORT:-3306}..."
    ATTEMPTS=0
    until mysqladmin ping -h"${DB_HOST}" -P"${DB_PORT:-3306}" -u"${DB_USER:-bazma}" -p"${DB_PASSWORD:-}" --ssl=0 --silent; do
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

if [ "${APP_DEBUG:-0}" = "1" ] || [ "${APP_DEBUG:-0}" = "true" ]; then
    CONSOLE_DEBUG_FLAG="--debug"
else
    CONSOLE_DEBUG_FLAG="--no-debug"
fi

php bin/console cache:clear --env="${APP_ENV:-prod}" "${CONSOLE_DEBUG_FLAG}" --no-warmup
php bin/console cache:warmup --env="${APP_ENV:-prod}" "${CONSOLE_DEBUG_FLAG}"
chown -R www-data:www-data var public/uploads

exec "$@"
