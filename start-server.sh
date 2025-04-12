# start-server.sh
#!/bin/bash
set -e

php artisan config:clear
php artisan cache:clear

# Gunakan port dari ENV atau default 8080
php -S 0.0.0.0:${PORT:-8080} -t public