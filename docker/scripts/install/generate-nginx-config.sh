#!/bin/sh

CONF_DIR=docker/nginx/conf/conf.d
TMP_DIR=docker/nginx/conf/example-tmp
TMP_CONF_FIlE="$TMP_DIR"/host.conf.tmp

if [ ! -d "$CONF_DIR" ]; then
  mkdir "$CONF_DIR"
fi

if [ -f "$TMP_DIR/default.conf" ]; then
  cp "$TMP_DIR/default.conf" "$CONF_DIR/default.conf"
fi

for i in $(echo $1 | tr ";" "\n")
do
  if [ ! -f "$CONF_DIR/$i.conf" ]; then
    reg='$(HOST)'
    sed "s/$reg/$i/g" "$TMP_CONF_FIlE" > "$CONF_DIR/$i.conf"
  fi
done
