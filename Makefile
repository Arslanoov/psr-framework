up: docker-clear docker-build docker-up composer-install
check: int cs

docker-clear:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

composer-install:
	docker-compose run --rm furious-php-cli composer install

composer-update:
	docker-compose run --rm furious-php-cli compsoer update

generate-migration:
	docker-compose run --rm furious-php-cli php bin/console migrations:diff

migrate:
	docker-compose run --rm furious-php-cli php bin/console migrations:migrate

lint:
	docker-compose run --rm furious-php-cli composer lint

cs:
	docker-compose run --rm furious-php-cli composer cs-check
