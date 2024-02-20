Hiberus Tests
==========
&nbsp;

Table of contents
---
* [Overview](#overview)
* [System Requirements](#system-requirements)
* [Installation](#installation)
* [Run the container](#run-the-container)
* [Tests](#tests)
* [Docker CLI commands](#docker-cli-commands)
* [Documentation](#documentation)
* [Browser Compatibility](#browser-compatibility)
* [CSS Standards](#css-standards)
* [Troubleshooting](#troubleshooting)

\
Overview
---
XALOK is part of a test for Hiberus. Its purposes are:
* Provide the Web GUI to create / register trips.
* A fullstack habilities, using php and js.

\
System Requirements
---
### `🐳` Docker
<details>
<summary>⚙️ View Instructions</summary>

Install Docker for your platform.
Documentation: https://docs.docker.com/get-docker/

| OS      | Installer                                        |
| ------- | ------------------------------------------------ |
| macOS   | https://docs.docker.com/desktop/mac/install/     |
| Windows | https://docs.docker.com/desktop/windows/install/ |
| Linux   | https://docs.docker.com/engine/install/          |
</details>

### `📝` Docker Compose
<details>
<summary>⚙️ View Instructions</summary>

Install [docker-compose](https://docs.docker.com/compose/) for your platform.

| OS      | Installer                                               |
| ------- | ------------------------------------------------------- |
| macOS   | Included with Docker                                    |
| Windows | Included with Docker                                    |
| Linux   | Please see your distributions package management system |
</details>

### `🔐` Composer Authentication
<details>
<summary>⚙️ View Instructions</summary>

**TODO**
> - [x] Add Dockerfile
> - [x] Add Intruccions

<details>
<summary>ℹ️ How to set environment variables</summary>

- Replace the COMPOSER_HOME value and the destination file according to your OS.

Run the following commands to add variables to your env file depending on your operating system.
- macOS with zsh shell:
```bash
echo 'export COMPOSER_HOME=~/.composer' >> ~/.zshenv
```
- macOS with bash shell:
```bash
echo 'export COMPOSER_HOME=~/.composer' >> ~/.bash_profile
```
- Linux with bash shell:
```bash
echo 'export COMPOSER_HOME=~/.config/composer' >> ~/.bashrc
```
- Windows:
```bash
setx COMPOSER_HOME "%APPDATA%..\Roaming\Composer"
```
</details>

</details>

\
Installation
---
### `🧲` Repository
First we need to clone the repository from GitHub.
```bash
cd ~/Sites # or whatever directory you keep your projects in
git clone https://github.com/jok3rcito0/xalok
cd xalok
```
> **Note:** If you are prompted to insert your GitHub credentials after the `git clone` command, you must **enter your personal access token as password**, not your account password.
___
### Manual Install

Once clone command completes, we need to copy the `docker-compose.yml.dist` file and update it for our system.

```bash
cp .env.dist .env
cp docker-compose.override.yml.dist docker-compose.override.yml
```
> **Note:** _Personalize the `docker-compose.override.yml` for your system. If you are using Mac, it is recommended to change `- .:/application` to `- .:/application:cached` for the best performance. However, the default file will work out of the box._

### `🎯` Docker Images
Pull and build the docker images.
```bash
docker-compose pull
docker-compose build
```

### `😎` PRO Tip: Shorten the Docker Compose command
We are using PHP, Node, etc. through Docker. In order to use tools like Composer and Yarn through Docker, we must pass our commands to the Docker container. This is a really long command:

`docker-compose -f docker-compose.cli.yml run --rm composer install`

Because of this, it is recommended to create an alias for `docker-compose -f docker-compose.cli.yml run --rm` and call it `dcli` (Docker CLI).

To create these alias, you can use any of the following commands depending on your OS
```bash
# For macOS with zsh shell
echo "alias dcli='docker-compose -f docker-compose.cli.yml run --rm'" >> ~/.zshrc
# For MacOS with bash shell
echo "alias dcli='docker-compose -f docker-compose.cli.yml run --rm'" >> ~/.bash_profile
# For Linux with bash shell
echo "alias dcli='docker-compose -f docker-compose.cli.yml run --rm'" >> ~/.bashrc
```

### `🔌` Install Dependencies

> ⚠️ Important: _If you are migrating from pre-existing setup, remove the `vendor` and `node_modules` directories before continue._

Now that we have the application configured, we need to install the dependencies.
Run the following commands:
```bash
dcli composer install
dcli yarn install
```

### `🏰` Frontend Assets
Now it's time to build the frontend assets. Run the following commands

```bash
dcli yarn gulp
```

\
Run the container
---
And finally it's time to start up our containers:
```bash
docker-compose up -d
```
> Without nginx-proxy you can only access one of the sites at a time, based the `X-Store` header sent in the request. By default `mx` is used.
>

\
Tests
---
To run the frontend and backend tests,  run these commands according to what you need:

* Frontend tests:
```bash
dcli yarn test:js
```
> **Note 1:** _Add front test._
**
* Backend tests:
```bash
dcli composer test
```
> **Note 2:** _Add backend test._

\
Docker CLI commands
---
The Docker CLI -`dcli`- has services for common commands and for each language.

### `»` Available Services
* node
* php
* composer

### `»` Syntax
If you want to run a script, use `dcli` command as:
```bash
dcli {node|php|composer} [script] [--flag]
```

### `»` Composer Commands

| Command                        | Description                                                       |
|--------------------------------|-------------------------------------------------------------------|
| ```dcli composer install```    | Install backend dependencies                                      |
| ```dcli composer lint:check``` | Lint backend sources, including `.php`, `.yaml` and `.twig` files |
| ```dcli composer lint:yaml```  | Lint `.yaml` files in `/config` and `/translations` folders       |
| ```dcli composer lint:twig```  | Lint `.twig` files in `/templates` folder                         |
| ```dcli composer lint```       | Fix backend sources with php-cs-fixer                             |
| ```dcli composer phpstan```    | Analyze php files with phpstan                                    |
| ```dcli composer phpunit```    | Run phpunit to check tests in `/tests` folder                     |
| ```dcli composer security```   | Check for security problems in php files                          |
| ```dcli composer test```       | Performs lint:check, phpstan, phpunit and security commands       |

\
Documentation
---

### `»` OpenAPI

> **Note:** _Generate documentation._

\
Browser Compatibility
---
The minimum and recommended versions for web browsers are listed in the following table

| Browser          | Minimum Version | Recommended Version |
|------------------|-----------------|---------------------|
| Google Chrome    | 52+             | 82+                 |
| Apple Safari     | 9.1+            | 10+                 |
| Mozilla Firefox  | 48+             | 80+                 |
| Microsoft Edge   | 87+             | 91+                 |
| Samsung Internet | 7.2+            | 13+                 |


> More information about compatibility with web browsers at https://caniuse.com/

\
CSS Standards
---
The CSS code written in `.scss` files must meet the XALOK CSS and SCSS standards.

\
Troubleshooting
---
### `⛔️` Error response from daemon:network

```
Error response from daemon: network ec77598403f3599c5a9de562dd94fa1ebaeb60281706778f2db7abe5ddd7c7ae not found
Error: failed to start containers: nginx-proxy
```

This is caused by nginx-proxy searching for a Docker network that doesn't exist anymore. To solve this you need to remove the container and execute the `nginx-proxy.sh` script again.

```bash
docker rm -f nginx-proxy
docker/nginx-proxy.sh
```