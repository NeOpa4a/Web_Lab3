FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    zip unzip git curl

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
