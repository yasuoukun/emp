#!/bin/bash

echo "Running migrations..."
php artisan migrate --force

echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment script completed successfully!"
