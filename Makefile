init: docker-down-clear \
	api-clear frontend-clear \
	docker-pull docker-build docker-up \
	api-init frontend-init
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-init: api-permissions api-composer-install api-wait-db api-migrations

api-permissions:
	docker run --rm -v ${PWD}/api:/app -w /app alpine chmod 777 var/cache var/log var/test

api-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/* var/test/*'

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-wait-db:
	docker-compose run --rm api-php-cli wait-for-it api-postgres:5432 -t 30

api-migrations:
	docker-compose run --rm api-php-cli composer app migrations:migrate -- --no-interaction

frontend-clear:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'rm -rf build'

frontend-init: frontend-yarn-install

frontend-yarn-install:
	docker-compose run --rm frontend-node-cli yarn install
