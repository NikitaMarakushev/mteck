ARG PHP_VERSION=8.1.0
ARG COMPOSER_VERSION=2.2.5

FROM composer:${COMPOSER_VERSION} AS mteck-composer

FROM php:${PHP_VERSION}-fpm-bullseye AS app_php

#Installing composer
COPY --from=mteck-composer /usr/bin/composer /usr/local/bin/composer

MAINTAINER Nikita Marakushev <nikitamarakushev@yandex.ru>

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions zip gd exif intl memcached opcache pcntl pdo_pgsql pgsql && \
    composer --version && \
    php -v


ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      install-php-extensions xdebug; \
    fi;


# Install packages
RUN apt-get update && apt-get install -y --no-install-recommends git wget sudo unzip \
    && rm -rf /var/lib/apt/lists/* \


#Application params
COPY docker/php/conf.d/app.ini $PHP_INI_DIR/conf.d/

EXPOSE 9000

WORKDIR /srv