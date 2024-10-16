#!/bin/sh




php artisan schedule:work &

php artisan queue:work &

php artisan view:clear
php artisan cache:clear

php-fpm
