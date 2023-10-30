#!/bin/bash
php artisan migrate:fresh
php artisan db:seed --class=MovieSeeder
php artisan db:seed --class=MovieSeeder
