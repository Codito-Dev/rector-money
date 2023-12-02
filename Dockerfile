FROM php:8.3-cli-alpine

WORKDIR /etc/rector

RUN mkdir -p /etc/rector

RUN apk add --no-cache icu \
    && apk add --no-cache --update \
      --virtual .build-deps \
      $PHPIZE_DEPS \
      icu-dev \
      linux-headers \
    && pecl install xdebug-3.3.0 \
    && docker-php-ext-install bcmath intl \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

# See: https://blog.codito.dev/2022/11/composer-binary-only-docker-images/
COPY --from=composer/composer:2-bin /composer /usr/bin/composer
