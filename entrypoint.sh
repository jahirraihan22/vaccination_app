#!/bin/bash

# Start the PHP-FPM service in the background
php-fpm &

# Run the Laravel scheduler in the background
php artisan schedule:work &

# Run the Laravel queue worker
php artisan queue:work
