up: docker-clear docker-build docker-up composer-install

docker-clear:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

composer-install:
	docker-compose run --rm furious-php-cli compsoer install

composer-update:
	docker-compose run --rm furious-php-cli compsoer update
