FROM lapig/content_hub:base AS python-base

ENV URL_TO_APPLICATION_GITHUB="https://github.com/lapig-ufg/content-hub"
ENV BRANCH="develop"


ENV COMPOSER_ALLOW_SUPERUSER=1 \ 
    APP_ENV=production \
    APP_DEBUG=true 

# setup user as root
USER root

WORKDIR /var/www/server

COPY ./docker/homologation/deploy/local.ini /usr/local/etc/php/conf.d/docker-fpm.ini
COPY ./docker/homologation/deploy/conf.d/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/homologation/post_deploy.sh /var/www/post_deploy.sh

COPY ./version.jso* /var/html/version.json

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    git clone -b ${BRANCH} ${URL_TO_APPLICATION_GITHUB} /tmp/app && \
    cp -R /tmp/app/server /var/www/ && \
    rm -Rf /tmp/app/ && \
    chown -R www-data:www-data /var/www/ 
    

RUN chmod +x /var/www/post_deploy.sh && \
    composer install && \
    composer dump-autoload && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    composer clear-cache

EXPOSE 80


CMD [ "sh", "/var/www/post_deploy.sh" ]


