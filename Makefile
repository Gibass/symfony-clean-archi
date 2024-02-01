MAKEFLAGS += --silent

include .env

# Executable
WORKSPACE:=$(shell pwd)
UID:=$(shell id -u)

DOCKER_COMPOSE_FILE=${WORKSPACE}/docker/compose/docker-compose.yml
CMD_DOCKER_COMPOSE=docker-compose -f ${DOCKER_COMPOSE_FILE} --project-directory ${WORKSPACE} ## Point docker to directory's root to find env file

PHP_CLI=$(CMD_DOCKER_COMPOSE) exec --user www-data php
PHP_CLI_ROOT=$(CMD_DOCKER_COMPOSE) exec php

ifneq ($(ENV),dev)
	COMPOSERARG?=--no-dev
endif

export WORKSPACE
export UID

install: ## Install project dependencies
	$(info --> Install for ENV: ${ENV})
ifeq ($(PROJECT_TYPE),web)
	make generate-certificate
	make nginx-config
endif
	make up
	make install-symfony

generate-certificate: ## generate certificate SSL for $(HOST) domain
	sh ./docker/scripts/install/generate-certificate.sh $(HOST)

nginx-config: ## generate nginx config file
	sh ./docker/scripts/install/generate-nginx-config.sh $(HOST)

install-symfony: ## install symfony
	$(PHP_CLI) sh ./docker/scripts/install/install-symfony.sh $(FULL_WEB)

up: ## docker-compose up -d with good env variables
	$(CMD_DOCKER_COMPOSE) up -d

build: ## docker-compose build
	$(CMD_DOCKER_COMPOSE) build --no-cache

stop: ## docker-compose stop
	$(CMD_DOCKER_COMPOSE) --profile debug --profile build stop

php-install-dependencies: ## Composer install
	$(CMD_CLI) composer install $(COMPOSERARG)

ssh-nginx: ## Ssh into nginx container (www-data)
	$(CMD_DOCKER_COMPOSE) exec -w /var/www/html nginx /bin/bash

ssh-php: ## Ssh into php container (www-data)
	$(PHP_CLI) sh

php-cs-fixer:
	make php-cs-fixer-fix ARGS="--dry-run --diff -vv ${ARGS}";

php-cs-fixer-fix:
	$(PHP_CLI) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix\
			${ARGS}\
			--config=tools/php-cs-fixer/.php-cs-fixer.dist.php

test:
	make test-unit
	make test-integration
	make test-system

test-unit:
	$(PHP_CLI) php bin/phpunit --stop-on-failure --testdox --testsuite unit $(ARGS)

test-integration:
	$(PHP_CLI) php bin/phpunit --stop-on-failure --testdox --testsuite integration $(ARGS)

test-system:
	$(PHP_CLI) php bin/phpunit --stop-on-failure --testdox --testsuite system $(ARGS)

test-coverage:
	$(PHP_CLI) php bin/phpunit --coverage-html public/test-coverage