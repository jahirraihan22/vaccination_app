#!/bin/bash


php artisan schedule:work &

php artisan queue:work &

php-fpm
