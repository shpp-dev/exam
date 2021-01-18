FROM php:7.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS oniguruma-dev libzip-dev curl-dev \
    && docker-php-ext-install pdo_mysql mbstring zip curl \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.8.5

RUN mkdir -p /project/backend

COPY backend /project/backend

WORKDIR /project/backend

RUN cd /project/backend && composer install
RUN cd /project/backend && php artisan config:cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080