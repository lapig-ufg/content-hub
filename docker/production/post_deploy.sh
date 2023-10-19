#!/bin/bash

# update application cache
php artisan optimize
php artisan optimize:clear

# start the application
php-fpm -D && nginx -g "daemon off;"

chmod -R 775 /var/www/server/storage && \
chmod -R 775 /var/www/server/bootstrap/cache && \
chown www-data:www-data /var/www/server/bootstrap/cache && \
chown www-data:www-data /var/www/server/storage/*
