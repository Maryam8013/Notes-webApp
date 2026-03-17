#!/bin/sh
set -e

if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
fi

set_env() {
  key="$1"
  value="$2"
  if [ -z "$value" ]; then
    return
  fi
  escaped_value=$(printf '%s' "$value" | sed -e 's/[\/&]/\\&/g')
  if grep -q "^${key}=" /var/www/.env; then
    sed -i "s#^${key}=.*#${key}=${escaped_value}#g" /var/www/.env
  else
    printf '%s=%s\n' "$key" "$value" >> /var/www/.env
  fi
}

set_env APP_URL "$APP_URL"
set_env FRONTEND_URL "$FRONTEND_URL"
set_env DB_CONNECTION "$DB_CONNECTION"
set_env DB_HOST "$DB_HOST"
set_env DB_PORT "$DB_PORT"
set_env DB_DATABASE "$DB_DATABASE"
set_env DB_USERNAME "$DB_USERNAME"
set_env DB_PASSWORD "$DB_PASSWORD"
set_env JWT_SECRET "$JWT_SECRET"

if grep -q "^APP_KEY=$" /var/www/.env; then
  php artisan key:generate --force
fi

if ! grep -q "^JWT_SECRET=" /var/www/.env; then
  printf '%s\n' "JWT_SECRET=" >> /var/www/.env
fi

if grep -q "^JWT_SECRET=$" /var/www/.env; then
  php artisan jwt:secret --force
fi

mkdir -p /var/www/storage/framework/views \
  /var/www/storage/framework/cache \
  /var/www/storage/framework/sessions \
  /var/www/storage/logs \
  /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
