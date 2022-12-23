#!/bin/bash

set -e
prog_name=$(basename $0)
ZIP_VERSION=032022
export DOCKER_BUILDKIT=0
export COMPOSE_DOCKER_CLI_BUILD=0

sub_rebuild(){
    echo ""
    echo "REBUILD :: bringing containers down"
    echo ""
    docker-compose down

    echo ""
    echo "REBUILD :: bringing containers up-to-date!"
    echo ""
    docker-compose build app

    echo ""
    echo "REBUILD :: composer install on api container"
    echo ""
    docker-compose run app composer install

    echo ""
    echo "REBUILD :: migrate and seed data"
    echo ""
    docker-compose run app php artisan migrate --seed

    echo ""
    echo "REBUILD :: bringing raven containers UP!"
    echo ""
    docker-compose up -d --remove-orphans


}

sub_start(){
    echo ""
    echo "START :: bringing raven containers UP!"
    echo ""
    docker-compose up -d

    echo "START :: application is available on http://localhost:8000"
}

sub_stop(){
    echo ""
    echo "STOP :: bringing raven containers down"
    echo ""
    docker-compose down --remove-orphans
}

sub_phpunit(){
    echo ""
    echo "PHPUNIT :: bringing unittest containers up"
    echo ""
    docker-compose down
    docker-compose up -d unittest

    echo ""
    echo "PHPUNIT :: docker-compose exec unittest /app/vendor/bin/phpunit --configuration phpunit-local.xml --testdox --exclude-group externalDependency --coverage-text"
    echo ""
    docker-compose exec unittest /app/vendor/bin/phpunit --configuration phpunit-local.xml --testdox --exclude-group externalDependency --coverage-text
    echo ""
    echo "PHPUNIT :: docker-compose exec --workdir vendor/falcon/falcon.backend-engine unittest /app/vendor/bin/phpunit --testdox --exclude-group externalDependency --coverage-text"
    echo ""
    docker-compose exec --workdir /app/vendor/falcon/falcon.backend-engine unittest /app/vendor/bin/phpunit --testdox --exclude-group externalDependency --coverage-text

    echo ""
    echo "PHPUNIT :: bringing unittest containers down"
    echo ""
    docker-compose down
}

sub_help(){
    echo -e "Usage: $prog_name <subcommand>\n"
    echo "Subcommands:"
    echo "    rebuild          Build/rebuild raven environment"
    echo "    start            Start raven environment"
    echo "    stop             Stop raven environment"
    echo "    restart          Stop and start raven environment"
    echo "    phpunit          PHP unit and smoke test raven environment"
    echo ""
}

subcommand=$1
case $subcommand in
    "" | "-h" | "--help")
        sub_help
        ;;
    *)
        shift
        sub_${subcommand} $@
        if [ $? = 127 ]; then
            echo "Error: '$subcommand' is not a known subcommand." >&2
            echo "       Run '$prog_name --help' for a list of known subcommands." >&2
            exit 1
        fi
        ;;
esac

