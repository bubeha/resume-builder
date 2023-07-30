ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm-alpine

ARG XDEBUG_VERSION

RUN apk add --no-cache git linux-headers icu-dev \
    && git clone --branch ${XDEBUG_VERSION} --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install xdebug intl \
    && apk del git

COPY ./common/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /application
