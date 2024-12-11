.PHONY: install up migrate test test-coverage docs

install:
	composer install

up:
	./vendor/bin/sail up -d

migrate:
	docker-compose exec laravel-profiling bash -c "php artisan migrate:fresh --seed"

test:
	docker-compose exec laravel-profiling bash -c "./vendor/bin/phpunit"

test-coverage:
	docker-compose exec laravel-profiling bash -c "./vendor/bin/phpunit --coverage-html=coverage"

docs:
	docker-compose exec laravel-profiling bash -c "php artisan l5-swagger:generate"


