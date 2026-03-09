#!/bin/sh
set -e

if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
fi

if grep -q "^APP_KEY=$" /var/www/.env; then
  php artisan key:generate --force
fi

php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
