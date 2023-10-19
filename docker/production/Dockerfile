FROM registry.lapig.iesa.ufg.br/lapig-images-prod/content-hub:base as python-base

ENV URL_TO_APPLICATION_GITHUB="https://github.com/lapig-ufg/content-hub"
ENV BRANCH="main"


ENV COMPOSER_ALLOW_SUPERUSER=1 \ 
    APP_ENV=production

# setup user as root
USER root

WORKDIR /var/www/server

# Install environment dependencies
RUN apt-get update \
	# gd
	&& apt-get install -y build-essential \
         openssl \
         nginx \
         libfreetype6-dev \
         libjpeg-dev \
         libpng-dev \
         libwebp-dev \
         zlib1g-dev \
         libzip-dev \
         gcc \
         g++ \
         make \
         nano \
         unzip \
         curl \
         git \
         jpegoptim \
         optipng \
         pngquant \
         gifsicle \
         locales \
         libonig-dev  \
         libpq-dev \
        libcurl4-openssl-dev \
        libxml2-dev \
    && docker-php-ext-configure gd  \
	&& docker-php-ext-install gd \
	# gmp
	&& apt-get install -y --no-install-recommends libgmp-dev libxml2-dev \
	&& docker-php-ext-install gmp \
	# pgsql
	&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pgsql mbstring \
        && docker-php-ext-install curl \
	# opcache
	&& docker-php-ext-enable opcache \
	# exif
    && docker-php-ext-install exif \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
	# zip
	&& docker-php-ext-install zip \
	&& apt-get autoclean -y \
	&& rm -rf /var/lib/apt/lists/* \
	&& rm -rf /tmp/pear/



COPY ./deploy/local.ini /usr/local/etc/php/conf.d/docker-fpm.ini
COPY ./deploy/conf.d/nginx.conf /etc/nginx/nginx.conf
COPY ./post_deploy.sh /var/www/post_deploy.sh

# Development config files

COPY ./version.jso* /var/html/version.json

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    git clone -b ${BRANCH} ${URL_TO_APPLICATION_GITHUB} /tmp/app && \
    cp -R /tmp/app/server /var/www/ && \
    rm -Rf /tmp/app/

RUN usermod -u 1000 www-data && \
    chown www-data:www-data /var/www/ && \
    chown -R www-data:www-data /var/www/server/* && \
    chmod -R 775 /var/www/server/storage && \
    chmod -R 775 /var/www/server/bootstrap/cache && \
    chown -R www-data:www-data /var/www/server/bootstrap/cache && \
    chown -R www-data:www-data /var/www/server/storage && \
    chmod +x /var/www/post_deploy.sh && \
    composer install && \
    composer dump-autoload && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    composer clear-cache

EXPOSE 80


CMD [ "sh", "/var/www/post_deploy.sh" ]


