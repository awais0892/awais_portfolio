#!/bin/bash
set -e

echo "Clearing stale config cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Caching config with correct runtime environment variables..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Waiting for MySQL to be ready..."
max_retries=30
count=0
until php artisan migrate:status > /dev/null 2>&1 || [ $count -ge $max_retries ]; do
    echo "MySQL not ready yet (attempt $((count+1))/$max_retries)... retrying in 3s"
    sleep 3
    count=$((count+1))
done

if [ $count -ge $max_retries ]; then
    echo "ERROR: Could not connect to MySQL after $max_retries attempts. Exiting."
    exit 1
fi

echo "Running migrations and seeding database ..."
php artisan migrate --force --seed

echo "Creating storage symlink..."
php artisan storage:link || true

echo "Starting application server..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
