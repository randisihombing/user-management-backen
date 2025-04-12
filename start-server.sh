#!/bin/bash
set -e

php artisan config:clear
php artisan cache:clear

# Gunakan ini untuk production:
php -S 0.0.0.0:8080 -t public public/index.php