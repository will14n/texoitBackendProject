#!/bin/bash

chown -R www-data:www-data /var/www/storage

chmod -R 755 /var/www/storage

printf "\n\nReseting database...\n\n"
php artisan migrate:fresh

printf "\n\nRegistering films in the database may take time depending on the amount of data...\n\n"
php artisan db:seed --class=MovieSeeder

printf "\n\nStarting PHP daemon...\n\n"
php-fpm --daemonize

printf "Starting Nginx...\n\n"
set -e

if [[ "$1" == -* ]]; then
    set -- nginx -g daemon off; "$@"
fi

exec "$@"
