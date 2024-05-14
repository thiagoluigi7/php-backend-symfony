# Symfony Docker

## Iniciando a aplicação

1. Para iniciar a aplicação é necessário ter o [install Docker Compose](https://docs.docker.com/compose/install/) instalado.
2. Execute o comando `docker compose build --no-cache && docker compose up --pull always -d --wait`. Ele irá construir o ambiente e iniciar a aplicação.
3. Agora abra `https://localhost` no navegador e [aceite os certificados TLS que foram gerados automaticamente](https://stackoverflow.com/a/15076602/1352334).
4. Os testes podem ser executados com o comando `docker compose exec php bin/phpunit`.
5. Para parar a aplicação use o comando `docker compose down --remove-orphans`

Com isto será possível testar a aplicação.

Qualquer dúvida pode mandar um email: thiagoluigi7@hotmail.com

## Comentários

Este repositório foi criado usando um template indicado pela documentação do Symfony. <br>
Os testes estão usando o mesmo banco que a aplicação. Em produção o banco de testes e o banco de produção devem ser separados. <br>
Se por algum acaso você estiver usando Linux e der algum erro de permissão, use este comando `docker compose run --rm php chown -R $(id -u):$(id -g) .`. É possível ler mais a respeito na seção de [Troubleshooting](docs/troubleshooting.md).

## Readme original

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Production, development and CI ready
* Just 1 service by default
* Blazing-fast performance thanks to [the worker mode of FrankenPHP](https://github.com/dunglas/frankenphp/blob/main/docs/worker.md) (automatically enabled in prod mode)
* [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
* Automatic HTTPS (in dev and prod)
* HTTP/3 and [Early Hints](https://symfony.com/blog/new-in-symfony-6-3-early-hints) support
* Real-time messaging thanks to a built-in [Mercure hub](https://symfony.com/doc/current/mercure.html)
* [Vulcain](https://vulcain.rocks) support
* Native [XDebug](docs/xdebug.md) integration
* Super-readable configuration

**Enjoy!**

## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
