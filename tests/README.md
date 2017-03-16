## Unit tests ##

The unit tests require the composer autoloader files ...

cd <reseller-api>
composer dump-autoload


After that you can run the tests:

cd <reseller-api>/tests
phpunit -c phpunit.xml . --coverage-html ../reports/coverage/html