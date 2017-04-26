# Configuration
YARNFILE := package.json
COMPOSERFILE := composer.json
GULPFILE := gulpfile.js
DEPLOY := Envoy.blade.php

# Tasks
all: install
install: yarn composerinstall
update: yarnupgrade composerupdate
status: yarncheck
build: gulp
buildproduction: gulpproduction
deploy: install build runtests envoy
deployproduction: install buildproduction runtests envoyproduction

# Commands
yarn: $(YARNFILE)
	yarn

composerinstall: $(COMPOSERFILE)
	composer update --lock

composerinstalldev: $(COMPOSERFILE)
	composer install --prefer-dist --no-scripts --no-interaction && composer dump-autoload --optimize;

composerinstallproduction: $(COMPOSERFILE)
	composer install --prefer-dist --no-dev --no-scripts --no-interaction && composer dump-autoload --optimize;

gulp: $(GULPFILE)
	gulp

gulpproduction: $(GULPFILE)
	gulp --env=production

watch: $(GULPFILE)
	gulp watch

yarnupgrade: $(YARNFILE)
	yarn upgrade

composerupdate: $(COMPOSERFILE)
	composer update

yarncheck: $(YARNFILE)
	yarn outdated

runtests: $(COMPOSERFILE)
	phpunit

phplint: $(COMPOSERFILE)
	php-cs-fixer fix

phplintdry: $(COMPOSERFILE)
	php-cs-fixer fix --diff --dry-run

coverage: $(COMPOSERFILE)
	php vendor/bin/phpunit --coverage-html coverages

envoy: $(DEPLOY)
	envoy run deploy

envoyproduction: $(DEPLOY)
	envoy run deploy --on="production"

clean:
	rm -rf node_modules vendor

# Initialize files if they don't exist
$(YARNFILE):
	yarn init

$(COMPOSERFILE):
	composer init

$(GULPFILE):
	touch $(GULPFILE)
