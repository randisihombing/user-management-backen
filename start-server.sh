#!/bin/bash

php artisan config:cache
php artisan migrate --force
php -S 0.0.0.0:9000 -t public
