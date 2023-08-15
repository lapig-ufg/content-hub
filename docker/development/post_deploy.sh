#!/bin/bash

. /var/www/.env
ssh -p 2522 -fN root@$SERVER -L 5432:127.0.0.1:5432
ssh -p 2522 -fN root@$SERVER -L 27017:127.0.0.1:27017

# update application cache
php artisan optimize
php artisan optimize:clear

# start the application
php-fpm -D && nginx -g "daemon off;"

chmod -R 775 /var/www/server/storage && \
chmod -R 775 /var/www/server/bootstrap/cache && \
chown www-data:www-data /var/www/server/bootstrap/cache && \
chown www-data:www-data /var/www/server/storage/*