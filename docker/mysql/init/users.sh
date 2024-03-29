#!/bin/sh

	mysql --user=root --password=$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE ${MYSQL_DATABASE}_test;"
	mysql --user=root --password=$MYSQL_ROOT_PASSWORD -e "CREATE USER ${MYSQL_USER}_test@'%' IDENTIFIED BY '${MYSQL_PASSWORD}_test';"
	mysql --user=root --password=$MYSQL_ROOT_PASSWORD -e "GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE}_test.* TO '${MYSQL_USER}_test'@'%';"
	mysql --user=root --password=$MYSQL_ROOT_PASSWORD -e "FLUSH PRIVILEGES;"