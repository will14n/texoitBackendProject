#!/bin/bash
# cd /var/www
# composer install
pwd
php artisan migrate:fresh
php artisan db:seed --class=MovieSeeder
# docker-entrypoint php-fpm
# /usr/bin/supervisord -n -c /etc/supervisord.conf
