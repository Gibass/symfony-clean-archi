#!/bin/sh

usermod -u ${DEV_UID} www-data
groupmod -g ${DEV_UID} www-data

chown -R www-data:www-data "$APP_DIR"
