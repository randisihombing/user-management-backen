#!/bin/bash
set -e

# Cache config dan jalankan migrasi
php artisan config:clear
php artisan cache:clear
php artisan migrate --force

# Gunakan PORT dari Railway atau default 8080
php -S 0.0.0.0:${PORT:-8080} -t public