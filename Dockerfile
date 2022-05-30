FROM php:7.4-cli-alpine

WORKDIR /etc/rector

RUN mkdir -p /etc/rector

RUN apk add --no-cache icu \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev \
    && pecl install xdebug \
    && docker-php-ext-install bcmath intl \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
