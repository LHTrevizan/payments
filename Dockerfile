# ==================================
# BUILDER CONTAINER
# ==================================
FROM php:7.4-fpm-alpine

RUN apk add curl && docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Installing PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app

# Build development dependencies
COPY ./ /var/www/app

RUN composer install --no-progress --working-dir=/var/www/app