#!/bin/sh

WORKSPACE=pwd
CERTS_DIR=docker/nginx/conf/certs
CERTS_DIR_PATH=$(cd "$(dirname "$CERTS_DIR")"; pwd)/$(basename "$CERTS_DIR")

for i in $(echo $1 | tr ";" "\n")
do
  if [ ! -d "$CERTS_DIR_PATH" ] || [ ! -f "$CERTS_DIR_PATH/$i.pem" ] || [ ! -f "$CERTS_DIR_PATH/$i-key.pem" ]; then
    if ! mkcert -version > /dev/null; then
      echo "\033[31mError: mkcert package is not installed or not executable, please install mkcert\033[m"
      exit 0;
    fi

    if [ ! -d "$CERTS_DIR_PATH" ]; then
      mkdir "$CERTS_DIR_PATH"
    fi

    cd "$CERTS_DIR_PATH"

    mkcert $i
  fi
done