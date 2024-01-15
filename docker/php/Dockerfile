#syntax=docker/dockerfile:1.4

FROM php:8.2-fpm-alpine AS php_upstream
FROM composer/composer:latest-bin AS composer_bin

FROM php_upstream AS php_base

ENV APP_DIR=/var/www/html

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
		shadow

RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions apcu intl opcache zip xdebug pdo_mysql

COPY conf.d/app.ini $PHP_INI_DIR/conf.d/

COPY --from=composer_bin /composer /usr/bin/composer

COPY conf.d/app.dev.ini $PHP_INI_DIR/conf.d/

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

WORKDIR "${APP_DIR}"