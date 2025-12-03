<h1 align="center">
  🚀 A Docker Starter Kit for Symfony
</h1>

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/php-^8.4-purple.svg?logo=php" alt="PHP version"/></a>
    <a href="#"><img src="https://img.shields.io/badge/composer-latest-blue.svg?logo=composer" alt="composer"/></a>
    <a href="#"><img src="https://img.shields.io/github/license/Naereen/StrapDown.js.svg" alt="license"/></a>
</p>

<p align="center">
    A Starter Kit to create new web or console Symfony Project quickly, with docker structure implementation
    <br />
    Using nginx for webserver with SSL autoconfiguration, and Mysql for database
</p>

## 🔧 Environment Setup

Some tools are required to install a project : 

### 🐳 Needed tools

1. [Docker](https://docs.docker.com/engine/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. make
4. mkcert <small>(Tools to generate a certificate for SSL)</small>

### 1- Environment configuration

Change your custom variable value in the dist file `env/.env.dev.dist`, according your project application and your environment (``dev|stage|prod``).

```dotenv
# in env/.env.dev.dist

##### Custom Environnement Variable #####
ENV=dev
DEBUG=true

## Install env var
APP_DIR=/var/www/html
SCRIPTS_DIR="${APP_DIR}/docker/scripts/entrypoint"
PROJECT_NAME=starter-kit-symfony
SYMFONY_VERSION=7.3.*
PROJECT_TYPE=web
FULL_WEB=false
HOST=dev.symfony-starter.mg

## Database
ROOT_PASSWORD=root
MYSQL_DB_HOST=database
MYSQL_DB_NAME=dbname
MYSQL_USERNAME=dbuser
MYSQL_PASSWORD=dbpassword
```

- ``APP_DIR`` : your app directory volume
- ``SCRIPTS_DIR`` : a directory to run scripts on container start (ex: file-permission.sh to set file permission)
- ``PROJECT_NAME`` : your project name
- ``SYMFONY_VERSION`` : The version of symfony that will be installed
- ``PROJECT_TYPE`` : a `web` or `console` project
- ``FULL_WEB`` : require weapp on symfony install if value is true
- ``HOST`` : A host if your project type is a `web` symfony project

Database configurations
- ``ROOT_PASSWORD`` : the root password
- ``MYSQL_DB_HOST`` : the database container name or external database host
- ``MYSQL_DB_NAME`` : name of the database
- ``MYSQL_USERNAME`` : username to access a database
- ``MYSQL_PASSWORD`` : user password to access a database

### 2- Configure your hosts
Add your domain to your hosts file ``(/etc/hosts)`` (ex: ``127.0.0.1 dev.symfony-starter.mg``)

### 3- Project Installation
After configuring the env file in `env/` folder, run installation with a `make install` command  

```shell
make install
```
