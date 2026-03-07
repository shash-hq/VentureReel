#!/bin/bash
set -e

# Guarantee APP_URL has a valid scheme before any artisan call
if [[ -z "$APP_URL" ]] || [[ "$APP_URL" != "http"* ]]; then
    export APP_URL="https://venturereel-production.up.railway.app"
fi

php artisan config:clear
php artisan cache:clear
php artisan migrate --force
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
