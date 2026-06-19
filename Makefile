COMPOSE = docker compose
APP = $(COMPOSE) exec app

.PHONY: build up down restart shell install update composer console \
	cache-clear cache-warmup logs serve \
	entity migration migrate rollback schema-validate \
	fixtures test routes debug-env reset-db tests

build:
	$(COMPOSE) build
	$(COMPOSE) run --rm app composer install

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart: down up

shell:
	$(APP) bash

install:
	$(COMPOSE) run --rm app composer install

update:
	$(COMPOSE) run --rm app composer update

composer:
	$(APP) composer $(cmd)

console:
	$(APP) php bin/console $(cmd)

cache-clear:
	$(APP) php bin/console cache:clear

cache-warmup:
	$(APP) php bin/console cache:warmup

serve:
	$(COMPOSE) up

logs:
	$(COMPOSE) logs -f app

# Symfony / Doctrine

entity:
	$(APP) php bin/console make:entity

controller:
	$(APP) php bin/console make:controller

migration:
	$(APP) php bin/console make:migration

migrate:
	$(APP) php bin/console doctrine:migrations:migrate --no-interaction

rollback:
	$(APP) php bin/console doctrine:migrations:migrate prev --no-interaction

schema-validate:
	$(APP) php bin/console doctrine:schema:validate

fixtures:
	$(APP) php bin/console doctrine:fixtures:load --no-interaction

# Debug

routes:
	$(APP) php bin/console debug:router

debug-env:
	$(APP) php bin/console debug:container --env-vars

# Tests

test:
	$(APP) php bin/phpunit

# Reset base de données

reset-db:
	$(APP) php bin/console doctrine:database:drop --force --if-exists
	$(APP) php bin/console doctrine:database:create
	$(APP) php bin/console doctrine:migrations:migrate --no-interaction
	$(APP) php bin/console doctrine:fixtures:load --no-interaction

api:
	$(APP) php bin/console make:controller --no-template $(name)

fixture:
	$(APP) php bin/console doctrine:fixtures:load --append --no-interaction

pint:
	$(APP) ./vendor/bin/pint --test

pint-c:
	$(APP) ./vendor/bin/pint

pint-v:
	$(APP) ./vendor/bin/pint --test -vv

tests:
	$(APP) php vendor/symfony/phpunit-bridge/bin/simple-phpunit tests