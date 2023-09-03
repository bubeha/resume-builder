DOCKER_COMPOSE = docker compose

init:
	$(DOCKER_COMPOSE) build --pull
	$(DOCKER_COMPOSE) run --rm php-cli composer install
	$(DOCKER_COMPOSE) up -d

start:
	$(DOCKER_COMPOSE) up -d --remove-orphans --force-recreate --build

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down --remove-orphans

update-deps:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer update

test:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run test

test-coverage:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run test-coverage

psalm:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run psalm -- --no-diff

analyze: psalm

lint:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run rector
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run php-cs-fixer -- --dry-run --diff