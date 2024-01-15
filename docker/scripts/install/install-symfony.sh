#!/bin/sh

if [ ! -f composer.json ]; then
  rm -Rf tmp/
  composer create-project "symfony/skeleton:$SYMFONY_VERSION" tmp --prefer-dist --no-interaction --no-install

  cd tmp
  composer require "php:>=$PHP_VERSION"

  if [ true = $1 ]; then
    composer config --json extra.symfony.docker 'false'
    composer require webapp --no-interaction
  fi

  composer config --json extra.symfony.docker 'true'

  cat ../env/.env.$ENV.dist >> .env
  cat ../.gitignore >> .gitignore

  cp -Rp . ..
  cd ..
  rm -Rf tmp/
fi