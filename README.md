<h1 align="center">
  🎯 A Clean Archi Project Example with Symfony
</h1>

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/php-^8.2-purple.svg?logo=php" alt="PHP version"/></a>
    <a href="#"><img src="https://img.shields.io/badge/symfony-^6.4-white.svg?logo=symfony" alt="PHP version"/></a>
    <a href="#"><img src="https://img.shields.io/badge/composer-latest-blue.svg?logo=composer" alt="PHP version"/></a>
    <a href="#"><img src="https://img.shields.io/github/license/Naereen/StrapDown.js.svg"/></a>
</p>

<p align="center">
A Project example to apply clean-architecture stricture with symfony code project.
</p>

## 🔧 Environment Setup

Some tools are required to install a project : 

### 🐳 Needed tools

1. [Docker](https://docs.docker.com/engine/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. make
4. mkcert <small>(Tools to generate a certificate for SSL)</small>

### 1- Environment configuration

Create your `.env` file from the dist file located in the `env/` folder according to your environment (``dev|stage|prod``).

Change variables value.

```dotenv
# in env/.env.dev.dist

##### Custom Environnement Variable #####
ENV=dev
DEBUG=true

## Install env var
PROJECT_NAME=starter-kit-symfony
SYMFONY_VERSION=6.3.*
PROJECT_TYPE=web
FULL_WEB=false
HOST=dev-starter-kit-symfony.mg

# Database conf
ROOT_PASSWORD=--------
MYSQL_DB_NAME=clean_archi_db
MYSQL_USERNAME=clean_archi_user
MYSQL_PASSWORD=--------
```

- ``PROJECT_NAME`` : your project name
- ``SYMFONY_VERSION`` : The version of symfony that will be installed
- ``PROJECT_TYPE`` : a `web` or `console` project
- ``FULL_WEB`` : require weapp on symfony install if value is true
- ``HOST`` : A host if your project type is a `web` symfony project

### 2- Project Installation
After creating and configure the `.env` file, run install with a `make install` command  

```shell
make install
```
