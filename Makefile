lint:
	PHP_CS_FIXER_IGNORE_ENV=true tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

setup:
	composer install
	cd tools/php-cs-fixer && composer install && cd -

test:
	vendor/bin/pest tests

coverage:
	php -d xdebug.mode=coverage vendor/bin/pest --coverage

serve:
	symfony server:start

analyse:
	php vendor/bin/phpstan analyse --level=8 --no-progress --no-interaction src
