# Use a imagem oficial do PHP com o Apache (pode ser outra versão, se preferir)
FROM php:8.0-apache

ENV URL_TO_APPLICATION_GITHUB="https://github.com/lapig-ufg/content-hub"
ENV BRANCH="develop"


# Instale as dependências necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git

# Instale extensões PHP necessárias para o Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo

# Instale o cliente PostGIS
RUN apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo_pgsql pgsql

# Defina o diretório de trabalho para o Apache
WORKDIR /var/www/html

# Clone o repositório do GitHub com o código-fonte do Laravel
RUN git clone -b ${BRANCH} ${URL_TO_APPLICATION_GITHUB} .

# Instale as dependências do Laravel
RUN composer install

# Configure as permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponha a porta do Apache
EXPOSE 80


# Inicie o servidor Apache
CMD ["apache2-foreground"]