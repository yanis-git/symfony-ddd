lint:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

setup:
	composer install
	cd tools/php-cs-fixer && composer install && cd -

test:
	vendor/bin/pest tests

coverage:
	php -d xdebug.mode=coverage vendor/bin/pest --coverage
