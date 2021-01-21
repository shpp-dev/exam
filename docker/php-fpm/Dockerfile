FROM php:7.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS oniguruma-dev libzip-dev curl-dev \
    && docker-php-ext-install pdo_mysql mbstring zip curl \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.8.5

WORKDIR /project/backend

COPY site/backend/ ./

RUN composer install

EXPOSE 8080

CMD php start-server