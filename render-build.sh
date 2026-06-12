#!/usr/bin/env bash
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan migrate --force