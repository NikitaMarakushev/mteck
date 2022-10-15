# Sets the default goal to be used if no targets were specified on the command line
.DEFAULT_GOAL := help

# Mark targets that do not represent physical files in the file system
.PHONY: help
.PHONY: up down rebuild logs
.PHONY: run bash psql migrate fixture db_rebuild

# Define constants
docker-compose := docker-compose --env-file=docker/.env -f docker/docker-compose.yml
php-cli-compose := docker-compose --env-file=docker/.env -f docker/php-cli-docker-compose.yml --project-name mteck
php-cli-compose-run := $(php-cli-compose) run --rm --name=mteck php-cli

# To escape a dollar sign $ in a Makefile, you have to double it
# %-20s minus indicates left alignment, 30 is the "field width"
# \033[32m green color
# \033[33m yellow color
# \033[0m reset color
help:
	@tail -n +2 $(MAKEFILE_LIST) | \
	grep -E '(^##)|(^[0-9a-zA-Z_-]+:.*?##.*$$)' | \
	awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m %-15s\033[0m %s\n", $$1, $$2}' | \
	sed -e 's/\[32m ##/[33m\n/'

## Docker main containers

up: ## Down, then build and up main containers
	@make down
	$(docker-compose) build
	$(php-cli-compose) build
	$(docker-compose) up -d --remove-orphans

down: ## Down main containers
	$(docker-compose) down --remove-orphans

rebuild: ## Pull images and rebuild main containers without using cache
	$(docker-compose) build --pull --no-cache
	$(php-cli-compose) build --pull --no-cache

logs: ## See docker-compose logs
	$(docker-compose) logs -f

## Get inside container

run: ## Run commands inside php-cli container. Example: make run bash OR make run bin/console make:migration
	@$(php-cli-compose-run) $(filter-out $@, $(MAKECMDGOALS))

bash: ## Run bash in php-fpm container
	docker exec -it php bash

psql-dev: ## Run psql in postgres container
	docker exec -it postgres psql -U mteck

migrate: ## Migrate
	$(php-cli-compose-run) bin/console doctrine:migrations:migrate --no-interaction --env=test

fixture: ## Load fixtures
	$(php-cli-compose-run) bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction --env=test

db_rebuild: ## Rebuild database: drop, create, migrate, load fixtures
	$(php-cli-compose-run) bin/console doctrine:database:drop --force --env=test
	$(php-cli-compose-run) bin/console doctrine:database:create --env=test
	$(php-cli-compose-run) bin/console doctrine:migrations:diff --no-interaction --env=test
	@make migrate
	@make fixture

## Tests, style, static analysis tools

tests: ## Run all tests in project
	$(php-cli-compose-run) bin/phpunit --testdox

tests_unit: ## Run unit tests
	$(php-cli-compose-run) bin/phpunit --testdox --testsuite "Unit Test Suite"

tests_functional: ## Run functional tests
	$(php-cli-compose-run) bin/phpunit --testdox --testsuite "Functional Test Suite"

tests_functional: ## Run acceptance tests
	$(php-cli-compose-run) bin/phpunit --testdox --testsuite "Acceptance Test Suite"

style: ## Run CS Fixer to fix style
	$(php-cli-compose-run) sudo vendor/bin/php-cs-fixer fix -vvv