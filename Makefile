
.DEFAULT_GOAL := help

.PHONY: help
.PHONY: up down rebuild logs
.PHONY: run bash psql migrate fixture db_rebuild

docker-compose := docker compose --env-file=docker/.env -f docker/docker-compose.yml
php-cli-compose := docker compose --env-file=docker/.env -f docker/php-cli-docker-compose.yml --project-name mteck
php-cli-compose-run := $(php-cli-compose) run --rm --name=mteck php-cli

help:
	@tail -n +2 $(MAKEFILE_LIST) | \
	grep -E '(^##)|(^[0-9a-zA-Z_-]+:.*?##.*$$)' | \
	awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m %-15s\033[0m %s\n", $$1, $$2}' | \
	sed -e 's/\[32m ##/[33m\n/'


up:
	@make down
	$(docker-compose) build
	$(php-cli-compose) build
	$(docker-compose) up -d --remove-orphans

down:
	$(docker-compose) down --remove-orphans

rebuild:
	$(docker-compose) build --pull --no-cache
	$(php-cli-compose) build --pull --no-cache

logs:
	$(docker-compose) logs -f

run:
	@$(php-cli-compose-run) $(filter-out $@, $(MAKECMDGOALS))

bash:
	docker exec -it php bash

psql-dev:
	docker exec -it postgres psql -U mteck

migrate:
	$(php-cli-compose-run) bin/console doctrine:migrations:migrate --no-interaction --env=test

fixture:
	$(php-cli-compose-run) bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction --env=test

db_rebuild:
	$(php-cli-compose-run) bin/console doctrine:database:drop --force --env=test
	$(php-cli-compose-run) bin/console doctrine:database:create --env=test
	$(php-cli-compose-run) bin/console doctrine:migrations:diff --no-interaction --env=test
	@make migrate
	@make fixture


tests:
	$(php-cli-compose-run) bin/phpunit --testdox

tests_unit:
	$(php-cli-compose-run) bin/phpunit --testdox --testsuite "Unit Test Suite"

tests_functional:
	$(php-cli-compose-run) bin/phpunit --testdox --testsuite "Functional Test Suite"

style:
	$(php-cli-compose-run) sudo vendor/bin/php-cs-fixer fix -vvv