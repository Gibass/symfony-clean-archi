#!/bin/sh

CERTS_DIR=docker/nginx/conf/certs

if [ ! -d "$CERTS_DIR" ] || [ ! -f "$CERTS_DIR/$1.pem" ] || [ ! -f "$CERTS_DIR/$1-key.pem" ]; then
  if ! mkcert -version > /dev/null; then
    echo "\033[31mError: mkcert package is not installed or not executable, please install mkcert\033[m"
    exit 0;
  fi

  if [ -d "$CERTS_DIR" ]; then
    rm -Rf "$CERTS_DIR"
  fi

  mkdir "$CERTS_DIR"
  cd "$CERTS_DIR"

  mkcert $1
fi