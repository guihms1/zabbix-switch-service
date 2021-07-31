#!/bin/sh

set -e

cd /var/www/html

composer install

php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
