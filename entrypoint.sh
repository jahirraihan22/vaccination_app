#!/bin/bash

# Run the Laravel scheduler in the background
php artisan schedule:work &

# Run the Laravel queue worker
php artisan queue:work
