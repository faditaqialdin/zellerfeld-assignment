.DEFAULT_GOAL := help

DC = docker compose
EXEC = $(DC) exec php
COMPOSER = $(EXEC) composer

#################################
Project:

## Enter the application container
php:
	@$(EXEC) sh

## Install the whole dev environment
install:
	@$(DC) build --no-cache

## Install composer dependencies
vendor:
	@$(COMPOSER) install --optimize-autoloader

## Update database schema
migrate-fresh:
	@$(EXEC) artisan migrate:fresh -f

seed:
	@$(EXEC) artisan db:seed

## Start the project
start:
	@$(DC) up -d --remove-orphans --no-recreate --wait

## Stop the project
stop:
	@$(DC) stop
	@$(DC) rm -v --force

logs:
	@$(DC) logs -f

## Run phpunit tests
test:
	@$(EXEC) artisan test

.PHONY: php install vendor migrate-fresh seed start stop logs test

