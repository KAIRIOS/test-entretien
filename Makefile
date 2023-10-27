DOCKER_COMPOSE = docker compose
APP = $(DOCKER_COMPOSE) exec application
PHP = $(APP) php
CONSOLE = $(PHP) bin/console

start:
	$(DOCKER_COMPOSE) up -d

stop:
	$(DOCKER_COMPOSE) down

unit-test:
	$(PHP) vendor/atoum/atoum/bin/atoum -d tests/units

bash:
	$(APP) bash

watch:
	$(APP) npm run watch

migration:
	$(CONSOLE) make:migration

migrate:
	$(CONSOLE) doctrine:migrations:migrate

fixtures:
	$(CONSOLE) doctrine:fixtures:load --no-interaction

#Used for start a local dev server
dev: start watch