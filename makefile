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
build: webpackprod
buildproduction: webpackprod
deploy: install build generatekey runtests envoy
deployproduction: install buildproduction generatekey runtests envoyproduction

# Commands
yarn: $(YARNFILE)
	yarn

generatekey: $(DOTENV)
	php artisan key:generate

composerinstall: $(COMPOSERFILE)
	composer update --lock --prefer-dist --no-interaction

composerinstalldev: $(COMPOSERFILE)
	composer install --prefer-dist --no-scripts --no-interaction && composer dump-autoload --optimize;

composerinstallproduction: $(COMPOSERFILE)
	composer install --prefer-dist --no-dev --no-scripts --no-interaction && composer dump-autoload --optimize;

webpackdev: $(MIXFILE)
	npm run dev

webpackprod: $(MIXFILE)
	npm run prod

watch: $(MIXFILE)
	npm run watch-poll

yarnupgrade: $(YARNFILE)
	yarn upgrade

composerupdate: $(COMPOSERFILE)
	composer update

yarncheck: $(YARNFILE)
	yarn outdated

runtests: $(COMPOSERFILE)
	php vendor/bin/phpunit

phplint: $(COMPOSERFILE)
	php-cs-fixer fix

phplintdry: $(COMPOSERFILE)
	php-cs-fixer fix --diff --dry-run

stylelint:
	stylelint ./resources/scss/**/*.scss --syntax scss

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

$(MIXFILE):
	touch $(webpack.mix.js)

$(DOTENV):
	cp .env.example .env
