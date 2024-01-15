#!/bin/sh

usermod -u ${DEV_UID} www-data
groupmod -g ${DEV_UID} www-data

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
  chown -R www-data:www-data "$APP_DIR"
fi

exec docker-php-entrypoint "$@"