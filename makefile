# Configuration
YARNFILE := package.json
COMPOSERFILE := composer.json
MIXFILE := webpack.mix.js
DEPLOY := Envoy.blade.php
DOTENV := .env

# Tasks
all: install
install: yarn composerinstall generatekey
update: yarnupgrade composerupdate
status: yarncheck
build: webpackdev
buildproduction: webpackprod
deploy: install buildproduction runtests envoy
deployproduction: install buildproduction runtests envoyproduction

# Commands
yarn: $(YARNFILE)
	yarn

generatekey: $(DOTENV)
	php artisan key:generate

composerinstall: $(COMPOSERFILE)
	composer update --lock --prefer-dist --no-interaction

composerinstalldev: $(COMPOSERFILE)
	composer install --prefer-dist --no-interaction && composer dump-autoload --optimize;

composerinstallproduction: $(COMPOSERFILE)
	composer install --prefer-dist --no-dev --no-interaction && composer dump-autoload --optimize;

webpackdev: $(MIXFILE)
	npm run development

webpackprod: $(MIXFILE)
	npm run production

watch: $(MIXFILE)
	npm run watch-poll

yarnupgrade: $(YARNFILE)
	yarn upgrade

composerupdate: $(COMPOSERFILE)
	composer update

yarncheck: $(YARNFILE)
	yarn outdated

runtests: $(COMPOSERFILE)
	php artisan view:clear
	php artisan config:clear
	php artisan test

phplint: $(COMPOSERFILE)
	./vendor/bin/pint

phplintdry: $(COMPOSERFILE)
	./vendor/bin/pint --test -v

stylelint:
	stylelint ./resources/scss/**/*.scss --syntax scss

coverage: $(COMPOSERFILE)
	phpbrew ext enable xdebug && XDEBUG_MODE=coverage php vendor/bin/phpunit --coverage-html coverages && phpbrew ext disable xdebug

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

$(MIXFILE):
	touch $(webpack.mix.js)

$(DOTENV):
	cp .env.example .env
