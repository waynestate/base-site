# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

This is the "Base Template" — a Laravel starter site used by Wayne State University to build content-driven websites (`waynestate/base-site`, live at https://base.wayne.edu/). It has **no database**: pages, menus, and promos are supplied by an external CMS as JSON files (or, in this repo, by the built-in styleguide which fakes that data). Backend is Laravel; frontend is Tailwind + SCSS bundled with Laravel Mix/webpack.

This repo is normally checked out inside `sites/base` of the `wsu-base-site-docker` environment (see the parent `CLAUDE.md` for Docker/container commands). Inside the container, run commands via `make` (which wraps yarn/composer/artisan/phpunit).

## Common commands

Run these from the project root (inside the site's container/shell):

```bash
make install          # yarn install + composer update + generate app key
make build             # webpack/mix dev build (npm run development)
make watch              # webpack watch with polling (for Docker volumes)
make buildproduction    # production asset build

make runtests           # clears view/config cache, then `php artisan test`
make coverage           # HTML coverage report (requires xdebug) -> coverages/index.html

make phplint            # apply Laravel Pint (PSR-12, pint.json)
make phplintdry         # check formatting without changing files (used in CI)
make phpstan            # Larastan static analysis (level 5, phpstan.neon), memory-limit=512M
make phpstandry         # same, no progress bar (CI-friendly)

make stylelint          # lint resources/scss/**/*.scss
make stylelintfix       # autofix SCSS
make eslint / make eslintfix   # ESLint on resources/js

make status             # yarn upgrade-interactive (check outdated JS deps)
make update             # yarn upgrade-interactive + composer update
```

Running a single test: use PHPUnit directly, e.g. `php artisan test --filter=TestClassName` or `./vendor/bin/phpunit --filter=testMethodName tests/Unit/Repositories/PageRepositoryTest.php`.

CI (`.github/workflows/build.yml`) runs, in order: `make yarn`, `make composerinstalldev`, `make build`, `make generatekey`, `make phplintdry`, `make stylelint`, `make runtests`, then coverage upload to Coveralls. Match this sequence when verifying changes locally.

Deployment is via Envoy, configured in `Envoy.blade.php`: `envoy run deploy` / `make deploy` (dev), `envoy run deploy --on="production"` / `make deployproduction`, or `envoy run deploy --branch=feature/x` for an arbitrary branch.

## Architecture: styleguide-mirrored request flow

Every request funnels through one route, and the entire page-data layer has two parallel implementations — real (CMS-backed) and styleguide (faked) — selected at runtime.

1. **Single catch-all route.** `routes/web.php` has explicit routes only for promos, profiles, and news; everything else hits `WildCardController::index`, which calls `app($request->controller)->index($request)`. `$request->controller` is set by middleware, not by routing.
2. **`App\Http\Middleware\Data`** runs on every request. It loads page JSON via `PageRepository::getRequestData()`, merges in server/meta data, runs the configured global-data callbacks (menu, promos), determines the controller class to invoke, and finally collapses everything into `$request->data['base']` (flattened deliberately to avoid key collisions with libraries like InertiaJS that also use `$page`).
3. **`App\Repositories\PageRepository`** turns a URL path into a JSON filename (`/` → `index.json`, `/foo/bar` → `foo_bar.json`) and reads it from the `public` disk under `storage/app/public/`. In production this JSON is written by the CMS; locally you hand-author files there to simulate CMS pages (see README "Pages" section for the JSON schema).
4. **Styleguide mode** (`using_styleguide()` in `app/Support/helpers.php`) is true when `APP_ENV=testing` or the request path starts with `/styleguide`. When active, `AppServiceProvider` and `Data` middleware swap the class prefix from `App` to `Styleguide`, so `Contracts\Repositories\XRepositoryContract` resolves to `Styleguide\Repositories\XRepository` (faker-backed, see `styleguide/Repositories/`) instead of `App\Repositories\XRepository` (real, CMS/API-backed). Controllers are shared between both modes.
5. **Repository binding by convention.** `AppServiceProvider::register()` scans every file under `contracts/Repositories/*Contract.php` and binds it to `{prefix}\Repositories\{Name}` — you do not hand-register new repository bindings; adding a contract + matching class in both `app/Repositories` and `styleguide/Repositories` is enough.
6. **Styleguide pages catalog.** `styleguide/Pages/*.php` (implementing `StyleguidePageContract`) enumerate every demo-able component/layout shown under `/styleguide`; `styleguide/menu.json` drives the styleguide's own nav. These exist purely for local development/QA of components and are not part of the production request path.

## Scaffolding a new feature

Don't hand-write the plumbing for a new content feature/component — use the Artisan command that scaffolds all the pieces at once:

```bash
php artisan base:feature Spotlight   # singular, CamelCase name
```

This creates, per `app/Console/Commands/BaseFeature.php` (using stubs in `stubs/`): a controller, a repository contract, a real repository (`app/Repositories`), a styleguide repository (`styleguide/Repositories`), a styleguide `Pages/*.php` entry + `styleguide/menu.json` item, a blade view, and a factory (`factories/`). Fill in the generated stubs rather than duplicating this wiring by hand.

## Global data & configuration

`config/base.php` is the single place controlling cross-cutting site behavior: layout name, hero placement/full-width controllers, top-menu behavior, meta/OpenGraph/Twitter defaults, news route slugs, profile settings, and — importantly — the `global` array defining per-site promo groups and `callbacks` (methods invoked on every request to attach global data such as menus/promos, see `Data` middleware). A local override file can be layered in via the `CONFIG_OVERRIDE` env var (merged with `array_replace_recursive_distinct`).

New `.env` variables must be wired through `config/base.php` via `env()` — see the "Adding `.env` variables" steps in `README.md` — and require a blank entry in `.env.example` plus the real value in `.env` (and eventually on each deployed server).

## Key directories

- `app/Http/Controllers` — one controller per selectable CMS template; controllers DI repositories via contracts and pass data to views.
- `app/Repositories` / `styleguide/Repositories` — real vs. faked data sources, implementing the same contracts in `contracts/Repositories`.
- `contracts/` — interfaces; adding one here (plus implementations) is what triggers the auto-binding described above.
- `resources/views` — Blade views, named to match controllers (e.g. `homepage.blade.php`); `resources/views/svg` holds icon partials used via the custom `@svg(...)` Blade directive; `resources/views/components` includes `image-lazy` used by the custom `@image(...)` directive (both registered in `AppServiceProvider::boot()`).
- `factories/` — Faker-based data factories used by the styleguide repositories to generate realistic-looking demo content.
- `tests/Feature` and `tests/Unit` — PHPUnit suites (see `phpunit.xml`); no real DB is used (`DB_CONNECTION=sqlite`, `:memory:`), and `app/Providers`, `app/Console/Commands`, and a few framework boilerplate files are excluded from coverage.