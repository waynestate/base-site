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
# Commands
yarn: $(YARNFILE)
	@if ! grep -q ".yarn" .gitignore > /dev/null 2>&1; then echo ".yarn/" >> .gitignore; fi
	corepack enable yarn
	yarn set version self
	yarn config set --home nodeLinker node-modules
	yarn config set --home enableImmutableInstalls false
	yarn config set --home enableTelemetry 0
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
	npm run dev

webpackprod: $(MIXFILE)
	npm run build

watch: $(MIXFILE)
	npm run dev-poll

yarnupgrade: $(YARNFILE)
	yarn upgrade-interactive

composerupdate: $(COMPOSERFILE)
	composer update

yarncheck: $(YARNFILE)
	yarn upgrade-interactive

runtests: $(COMPOSERFILE)
	php artisan view:clear
	php artisan config:clear
	php artisan test

phplint: $(COMPOSERFILE)
	./vendor/bin/pint

phplintdry: $(COMPOSERFILE)
	./vendor/bin/pint --test -v

phpstan: $(COMPOSERFILE)
	./vendor/bin/phpstan clear-result-cache
	./vendor/bin/phpstan analyse --memory-limit=512M

phpstandry: $(COMPOSERFILE)
	./vendor/bin/phpstan clear-result-cache
	./vendor/bin/phpstan analyse --memory-limit=512M --no-progress

stylelint:
	stylelint ./resources/css/**/*.css

stylelintfix:
	stylelint ./resources/css/**/*.css --fix

eslint:
	npm run lint

eslintfix:
	npm run lint:fix

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
