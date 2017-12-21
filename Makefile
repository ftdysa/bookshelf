.PHONY: install clean

clean:
	docker-compose rm -f
	rm -rf node_modules/
	rm -rf bower_components/
	rm -rf vendor/

up:
	docker-compose up -d

build:
	docker-compose kill
	docker-compose build

install: clean
	docker-compose up --build -d
	docker-compose exec -u bookshelf workspace composer install
	docker-compose exec -u bookshelf workspace yarn install
	docker-compose exec -u bookshelf workspace yarn run encore dev

update:
	docker-compose exec -u bookshelf workspace composer update

assets:
	docker-compose exec -u bookshelf workspace yarn run encore dev

bash:
	docker-compose exec -u bookshelf workspace bash

# Run unit tests.
test:
	docker-compose exec -u bookshelf workspace bash -c "cd tests && ../bin/phpunit Unit/"

# Run integration tests. Probably also needs some selenium setup.
test-integration:
	docker-compose exec -u bookshelf workspace bash -c "cd tests && ../bin/phpunit Integration/"
