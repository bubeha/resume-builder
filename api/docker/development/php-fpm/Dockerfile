ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm-alpine

ARG XDEBUG_VERSION

RUN apk add --no-cache postgresql-dev git linux-headers icu-dev ${PHPIZE_DEPS} \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && git clone --branch ${XDEBUG_VERSION} --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && pecl install apcu \
    && docker-php-ext-enable apcu opcache \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install pdo_pgsql xdebug intl \
    && apk del git \
    && rm -rf /var/cache/apk/*

COPY ./common/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /application
