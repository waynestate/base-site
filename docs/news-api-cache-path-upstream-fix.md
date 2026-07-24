# Upstream fix: `waynestate/news-api-php` cache path resolution

## Goal

Fix the root cause of the stray `sites/storage/` directory in `waynestate/news-api-php`
(currently v2.0.0) so the payload cache path is resolved **deterministically**,
independent of the process's current working directory. Today `News::setup()` calls
`mkdir($this->payload_dir, 02770, true)` with whatever raw string `config['cache']` holds
(`src/News.php:40,75-76`). When a consumer supplies a relative path like
`../storage/app/newsapi/`, the folder is created relative to CWD — correct under Apache
(CWD = `public/`), wrong under CLI/tests (CWD = project root), where it escapes into a
parent directory. The package should either resolve relative paths against a known base or
refuse them, and the Laravel config should default to an absolute path.

## Checklist items

- [ ] Reproduce in the package's own test suite: instantiate `News` with `cache` set to a
  relative path from two different CWDs, assert the directory is created in the same
  absolute location both times.
- [ ] In `src/News.php`, normalize the cache path in the constructor: trim/enforce a single
  trailing separator, and detect whether the path is absolute.
- [ ] For relative paths, resolve deterministically rather than silently `mkdir`-ing against
  CWD — resolve against a configurable base path (constructor/config option, defaulting to
  `getcwd()` only as an explicit last resort), or throw an `InvalidArgumentException` with a
  clear message.
- [ ] Update the Laravel published config `config/waynestatenews.php:19` to
  `'cache' => env('NEWS_API_CACHE', storage_path('app/newsapi'))` so Laravel consumers get an
  absolute default and only need the env var to override.
- [ ] Keep the framework-agnostic `getEnvVariables()` fallback (`src/News.php:55-62`) working
  for non-Laravel consumers — document that a relative `NEWS_API_CACHE` is resolved against
  the base path, not CWD.
- [ ] Add/extend PHPUnit tests (dev dep is phpunit ^9) covering: absolute path, relative
  path, empty path (existing early-return at `src/News.php:70`), and trailing-slash
  normalization.
- [ ] Bump version (2.0.0 → 2.1.0 for the additive config default; 3.0.0 if
  relative-without-base now throws — that's a breaking change), tag, and update
  `CHANGELOG`/README.
- [ ] In the base-site docker environment, bump the dependency
  (`composer update waynestate/news-api-php`) across consuming sites (`base`, `content`,
  `content2`, `go`) and confirm the `phpunit.xml` workaround in `base` can be removed.

## Possible pain points

- **Framework-agnostic constraint:** the package can't call Laravel's `storage_path()` in
  `src/News.php` (no Laravel dependency). Base-path resolution has to be handled either in the
  Laravel config layer or via a new constructor/config argument — decide where the base path
  comes from for standalone consumers.
- **Backward compatibility:** other WSU projects may already rely on the current
  relative-to-CWD behavior (even if accidentally). Throwing on relative paths could break
  them — this likely forces a major version bump and coordinated upgrades.
- **Access to the repo:** need push/PR rights on `github.com/waynestate/news-api-php` and the
  ability to tag a release + update Packagist. Confirm who owns that.
- **The `mkdir` mode `02770` and `chmod 02770`** (`src/News.php:76,82`) are unusual (setgid +
  no world access); preserve them so the fix doesn't change permission behavior consumers
  depend on.
- **Multiple consumers, one shared cache historically:** verify no site intentionally shares
  a single cache dir across sites; the fix scopes each to its own storage.

## Acceptance criteria

- Given a relative `cache`/`NEWS_API_CACHE` value, the payload directory is created in the
  **same absolute location regardless of the CWD** the code runs from (web, CLI, tests,
  queue).
- Laravel consumers with no `NEWS_API_CACHE` set get an absolute path under their own app's
  `storage/app/newsapi` by default.
- Running `base`'s test suite from the container's site root no longer creates
  `sites/storage/` — and the `NEWS_API_CACHE` override in `base/phpunit.xml` is no longer
  needed.
- New tests pass; existing behavior (empty path early-return, file creation, permissions) is
  unchanged.
- A tagged release is published and consuming sites are updated.

## List of deliverables

- PR against `waynestate/news-api-php` with the path-normalization fix in `src/News.php` and
  the absolute default in `config/waynestatenews.php`.
- New/updated PHPUnit tests covering CWD-independence and path normalization.
- Tagged release (2.1.0 or 3.0.0) on GitHub + Packagist, with `CHANGELOG` and README notes
  documenting the resolution behavior and any breaking change.
- Dependency bump + verification across `base`, `content`, `content2`, `go` in the docker
  environment, plus removal of the interim `phpunit.xml` workaround in `base`.

---

## Background / how we got here

The stray `sites/storage/app/newsapi/payload.json` folder in the docker environment was
traced to `base`'s test suite. `base/.env` sets `NEWS_API_CACHE=../storage/app/newsapi/`
(relative). Under Apache the CWD is `public/`, so `../storage` correctly resolves to the
site's own `storage/`. Under `php artisan test` the CWD is the site root
(`/usr/local/www/sites/base`), so `../storage` climbs one level out into the shared `sites/`
directory.

Interim workaround already applied in this repo: an absolute `NEWS_API_CACHE` override in
`base/phpunit.xml` pointing at the site's own storage. This upstream fix supersedes that
workaround.
