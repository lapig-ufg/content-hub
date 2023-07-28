# 2022 update
FROM php:8.2-fpm

ENV URL_TO_APPLICATION_GITHUB="https://github.com/lapig-ufg/content-hub"
ENV BRANCH="main"
# Configurar o PKG_CONFIG_PATH para apontar para o diretório do libcurl
ENV PKG_CONFIG_PATH=/usr/lib/x86_64-linux-gnu/pkgconfig

# Definir as variáveis de ambiente CURL_CFLAGS e CURL_LIBS
ENV CURL_CFLAGS=-I/usr/include \
 CURL_LIBS=-L/usr/lib/x86_64-linux-gnu-lcurl \
 LIBXML_CFLAGS=-I/path/to/libxml2/include \
 LIBXML_LIBS=-L/path/to/libxml2/lib-lxml2 \
 COMPOSER_ALLOW_SUPERUSER=1 \ 
 APP_ENV=development \
 APP_DEBUG=true 

# setup user as root
USER root

WORKDIR /var/www/html

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



COPY ./deploy/local.ini /usr/local/etc/php/local.ini
COPY ./deploy/conf.d/nginx.conf /etc/nginx/nginx.conf
COPY ./post_deploy.sh /var/www/post_deploy.sh

# Development config files
COPY ./ssh /root/.ssh
COPY ./version.jso* /var/html/version.json
COPY ./.env /var/www/.env


# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN rm -rf index.nginx-debian.html && git clone -b ${BRANCH} ${URL_TO_APPLICATION_GITHUB}:server .

RUN composer install

RUN composer dump-autoload && \
    php artisan config:cache && \
    php artisan route:cache && \
    chown www-data:www-data /var/www/ && \
    chown -R www-data:www-data /var/www/html/* && \
    chmod -R 775 /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache && \
    chown www-data:www-data /var/www/html/bootstrap/cache && \
    chown www-data:www-data /var/www/html/storage && \
    chmod +x /var/www/post_deploy.sh && \
    composer clear-cache


EXPOSE 80


CMD [ "sh", "/var/www/post_deploy.sh" ]
# CMD php artisan serve --host=127.0.0.1 --port=9000


