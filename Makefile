PHP_BIN=php
###############################################################################
## Make
sniff:
	mkdir -p tests/reports/sniff
	$(PHP_BIN) vendor/bin/phpcs -w -p -s --standard=vendor/flyeralarm/php-code-validator/ruleset.xml --report=code --report-junit=tests/reports/sniff/junit.xml src/ tests/client tests/config

##fixes autoamatically and shows sniffs that cannot be fixed automatically
fixnsniff: fix sniff

fix: sniff
	php vendor/bin/phpcbf --standard=vendor/flyeralarm/php-code-validator/ruleset.xml src

test:
	vendor/bin/phpunit -c tests/phpunit.xml --testdox-text tests/reports/unit/testdox.txt --log-junit tests/reports/unit/junit.xml --coverage-text=php://stdout --coverage-html tests/reports/unit/coverage/html tests/

phpcpd:
	vendor/sebastian/phpcpd/phpcpd src

all: fixnsniff phpcpd test