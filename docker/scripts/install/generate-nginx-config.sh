#!/bin/sh

CONF_DIR=docker/nginx/conf/conf.d
TMP_CONF_FIlE=docker/nginx/conf/example-tmp/host.conf.tmp

if [ ! -d "$CONF_DIR" ] || [ ! -f "$CONF_DIR/$1.conf" ]; then
  if [ -d "$CONF_DIR" ]; then
      rm -Rf "$CONF_DIR"
  fi

  reg='$(HOST)'
  mkdir "$CONF_DIR"
  sed "s/$reg/$1/g" "$TMP_CONF_FIlE" > "$CONF_DIR/$1.conf"
fi