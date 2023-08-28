lint:
	docker-compose exec php bash -c  'PHP_CS_FIXER_IGNORE_ENV=true tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src'

setup:
	docker-compose exec php bash -c  'composer install && cd tools/php-cs-fixer && composer install'

test:
	docker-compose exec php vendor/bin/phpunit tests

coverage:
	docker-compose exec php bash -c  'php -d xdebug.mode=coverage vendor/bin/pest --coverage'

serve:
	symfony server:start

analyse:
	docker-compose exec php bash -c  'php vendor/bin/phpstan analyse --level=8 --no-progress --no-interaction src'

up:
	docker-compose up

shell:
	docker-compose exec php bash

rector:
	docker-compose exec php vendor/bin/rector process
