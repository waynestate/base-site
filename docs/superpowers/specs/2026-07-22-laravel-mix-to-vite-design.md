# Migrate build tooling from Laravel Mix to Vite

Date: 2026-07-22

## Context

The base-site frontend is built with **Laravel Mix** (webpack under the hood) via `webpack.mix.js`. The app is Laravel 13 (`laravel/framework: ^13.20`), which ships first-class Vite support through `laravel-vite-plugin` and the `@vite()` Blade directive. The team wants to move off Laravel Mix to Vite.

`webpack.mix.js` does considerably more than compile SCSS/JS — any replacement has to preserve all of it:

- **Compiles** `resources/js/main.js` → `public/_resources/js/main.js` and `resources/scss/main.scss` → `public/_resources/css/main.css`, with source maps.
- **PostCSS pipeline** — `tailwindcss` + `autoprefixer` (Tailwind stays; see Non-Goals).
- **Cache-busting** — `mix.version()` in production; `resources/views/layouts/main.blade.php` references assets via the `mix('_resources/css/main.css')` / `mix('_resources/js/main.js')` helper (reads `mix-manifest.json`).
- **BrowserSync dev server** — proxies `https://base.wayne.localhost` with `usePolling` (Docker volume watching) and watches `app/**/*.php`, `resources/views/**/*.php`, the built CSS/JS, and `tailwind.config.js`.
- **Ancillary, non-compile work** (currently inlined in `webpack.mix.js`, and easy to lose in a naive swap):
  - Generates Blade files by copying from packages: `@waynestate/wsuheader`/`wsufooter` `dist/*.html` → `resources/views/components/{header,footer}.blade.php`, and `waynestate/error-{404,403,429,500}` `dist/*.php` → `resources/views/errors/*.blade.php`.
  - Rewrites the footer's hardcoded year to `{{ date('Y') }}`.
  - Copies error CSS/`.map`/PNG, fonts (`resources/fonts`), and images (`resources/images`) into `public/_resources/`.
  - Creates the `public/_static` → `storage/app/public` symlink.
  - Installs the `hooks/pre-commit` git hook (dev only).
  - Runs ESLint via `eslint-webpack-plugin`.
- Error Blade templates (`resources/views/errors/*.blade.php`) hardcode `<link href="/_resources/css/404.css">` etc. — these reference **copied** (not compiled) CSS and are independent of the bundler.

**Sequencing:** This migration is a prerequisite to, and lands **before**, the separate "Remove Tailwind CSS, replace with plain Dart Sass" work (`docs/superpowers/specs/2026-07-22-tailwind-to-sass-design.md`). Doing Vite first means the Tailwind removal only has to delete a PostCSS plugin from `postcss.config.js` instead of editing a `webpack.mix.js` that no longer exists. **Tailwind stays fully intact in this change** — the PostCSS pipeline (`tailwindcss` + `autoprefixer`) is carried over unchanged so compiled output is identical.

Decision: replace Laravel Mix with Vite + `laravel-vite-plugin`, preserving current compiled output and all ancillary behavior, as an isolated change with no CSS/JS authoring changes.

## Goals

- Remove `laravel-mix`, `webpack.mix.js`, and `eslint-webpack-plugin`; build with Vite + `laravel-vite-plugin`.
- Produce byte-equivalent compiled CSS/JS (same Sass + PostCSS(tailwind+autoprefixer) pipeline, same source-map behavior).
- Preserve every ancillary Mix step (generated Blade files, footer-year rewrite, asset copies, `_static` symlink, git-hook install) in a new home (Vite plugin hooks or a pre-build Node script).
- Replace the `mix()` Blade helper with Vite's manifest-based asset resolution (`@vite()` or an equivalent) and preserve production cache-busting.
- Provide a working Docker dev workflow: a polling `vite build --watch` that rebuilds assets into `public/_resources/` (no Vite dev server, no HMR — see Section 6).
- Update `package.json` scripts, the `Makefile` (`build`, `buildproduction`, `watch`), and confirm the CI `make build` step (`.github/workflows/build.yml`, Node 26.x) still passes.

## Non-Goals

- **No Tailwind removal and no CSS/SCSS authoring changes** — Tailwind + its PostCSS step and `tailwind.config.js` carry over unchanged. That work is the separate follow-up spec.
- No JS behavior/module refactor — `resources/js/main.js` and its imports are unchanged.
- No visual/UX change — compiled output must match `master`.
- No change to the third-party pre-built CSS (`wsuheader`/`wsufooter`) or the copied error-page assets.

## Design

### 1. Dependencies & PostCSS config

- **Add** `vite`, `laravel-vite-plugin`, and (if needed for the ancillary copy steps) a static-copy plugin such as `vite-plugin-static-copy`.
- **Remove** `laravel-mix`, `eslint-webpack-plugin`.
- **Keep** `sass`, `sass-loader` (Vite uses `sass` directly; `sass-loader` becomes unused and can be dropped), `postcss`, `autoprefixer`, `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`.
- Move the PostCSS plugin list out of `webpack.mix.js` into a standalone **`postcss.config.js`** (`tailwindcss` + `autoprefixer`). Vite auto-discovers it. Keeping it in a dedicated file is what lets the follow-up Tailwind-removal spec delete one line here instead of touching bundler config.

### 2. `vite.config.js` — entry points

Two inputs, matching the current two outputs: `resources/js/main.js` and `resources/scss/main.scss`. Use `laravel-vite-plugin` with `input: ['resources/scss/main.scss', 'resources/js/main.js']`.

### 3. Output path — keep `public/_resources`

**Decision: keep the current custom output path `public/_resources/`** (not Vite's default `public/build`). This minimizes churn — deploy tooling (`Envoy.blade.php`), server/Apache config, the copied-asset destinations, and the error-page `<link href="/_resources/css/404.css">` references all continue to assume `_resources/`.

Implementation: configure `laravel-vite-plugin` with `buildDirectory: '_resources'` (so hashed assets and `manifest.json` land under `public/_resources/`) and confirm the generated asset URLs resolve as `/_resources/...`. The error-page CSS is **copied**, not compiled, so it's independent of this — just keep its copy destination at `public/_resources/css` as today.

### 4. Blade asset integration

Replace `mix('_resources/css/main.css')` / `mix('_resources/js/main.js')` in `resources/views/layouts/main.blade.php` with `@vite(['resources/scss/main.scss', 'resources/js/main.js'])`. Because there is no Vite dev server (Section 6), no hot file is written, so `@vite()` always resolves assets from `manifest.json` under `public/_resources/` — the hashed filenames provide cache-busting, replacing `mix.version()`. Confirm the resolved URLs are `/_resources/...` per the Section 3 `buildDirectory` decision.

### 5. Ancillary tasks — new homes

The non-compile work in `webpack.mix.js` must move, or the build silently stops generating required files:

- **Generated Blade files** (wsuheader/footer/error `dist` → `resources/views/...`) and the **footer-year rewrite** — move to a small `scripts/prepare-assets.mjs` run as a `prebuild`/`prewatch` npm step (or a Vite `buildStart` hook). These currently run on every Mix invocation; they must run before every Vite build and watch build.
- **Static copies** (error CSS/map/PNG, fonts, images) — `vite-plugin-static-copy`, or fold into `scripts/prepare-assets.mjs`.
- **`_static` symlink** and **git-hook install** — move to the same prepare script (symlink is idempotent; guard the `EEXIST` case as the current code does).

### 6. Dev workflow — polling watch build (no HMR)

**Decision: no HMR / no Vite dev server.** Use `vite build --watch` with polling, which closely mirrors the current `mix watch` model: Vite watches the source and rebuilds hashed assets + `manifest.json` into `public/_resources/` on change; `@vite()` (in non-hot mode) serves those built files via the manifest. This deliberately avoids the Vite dev server, the HMR websocket, and any TLS-proxy tunneling.

- Enable polling for Docker bind-mount file events — `build.watch` plus `server.watch.usePolling: true` (and, if needed, `CHOKIDAR_USEPOLLING=true` in the container env), matching the current `usePolling`/`interval: 500` BrowserSync behavior.
- **No new Docker port is required** — because there's no dev server, the `base` service's existing `docker-compose.yml` port mappings are untouched (and there's no clash with the `content` service, which already claims host `5173`).
- Browser refresh is manual (as with a plain watch build). If automatic full-page reload is wanted later, a lightweight live-reload watcher can be added as a follow-up — it is **not** part of this migration.
- Confirm `base.wayne.localhost` continues to serve the built assets from `public/_resources/` through the existing Apache/proxy layer (unchanged — it already serves that path today).

### 7. ESLint

`eslint-webpack-plugin` goes away. ESLint already runs standalone via `make eslint` / `npm run lint` (`eslint.config.js`) — rely on that in the dev workflow and CI rather than coupling linting to the bundler.

### 8. Scripts, Makefile, CI

- `package.json` scripts: replace the `mix` scripts with Vite equivalents — `"build": "vite build"` (dev build), `"production": "vite build --mode production"`, and `"watch": "vite build --watch"` (the polling watch build from Section 6). Add a `prebuild`/`prewatch` hook (or a `predev`-style step) that runs the prepare script from Section 5. Keep `lint`/`lint:fix`.
- `Makefile`: `MIXFILE := webpack.mix.js` → the Vite config; `webpackdev`/`webpackprod`/`watch` targets call the new npm scripts; `build`/`buildproduction` unchanged in name so CI and `README` commands keep working.
- CI (`.github/workflows/build.yml`) runs `make build` on Node 26.x — verify a clean `vite build` succeeds there and that the manifest is produced where Blade expects it.

## Risks / things to watch during implementation

- **`mix()` → `@vite()` manifest mismatch on the custom `_resources` path** (Section 3) — the highest-risk item now that HMR is out of scope. `laravel-vite-plugin`'s `buildDirectory: '_resources'` must produce a manifest and asset URLs that resolve at `/_resources/...`; test the built (non-hot) asset URLs explicitly.
- **Silently dropped ancillary steps** — if the generated Blade files, asset copies, symlink, or footer-year rewrite aren't ported, the app breaks in non-obvious ways (missing header/footer, 404 styling, broken `_static` media). Verify each explicitly.
- **Polling watch behavior** (Section 6) — confirm `vite build --watch` actually picks up changes on the Docker bind mount (polling env/flag set); without it, edits won't rebuild.
- **Deploy tooling** — `Envoy.blade.php` / `make deployproduction` assumes the Mix build artifacts and paths; review it against the Vite build command (output path is unchanged at `_resources`, but the build invocation changes) before shipping.
- **`sass-loader` removal** — Vite compiles Sass via the `sass` package directly; confirm nothing else references `sass-loader` before removing it.

## Resolved decisions

1. **Output path** — keep `public/_resources` (via `laravel-vite-plugin` `buildDirectory: '_resources'`). See Section 3.
2. **Dev workflow** — no HMR / no Vite dev server; use `vite build --watch` with polling. See Section 6.

## Verification

- `make build` and `make buildproduction` succeed; compiled `main.css`/`main.js` are diff-equivalent to a `master` build (same Tailwind + autoprefixer output).
- All generated Blade files, copied assets, and the `_static` symlink are present after a clean build.
- Blade `@vite()` asset URLs resolve from the manifest at `/_resources/...` in both watch-build and production output.
- `make eslint`, `make stylelint`, `make runtests` pass; the full CI sequence in `.github/workflows/build.yml` is green.
- Manual smoke test of the polling watch build in Docker: run `make watch`, edit a `.scss` and a `.js` file, confirm Vite rebuilds the assets into `public/_resources/`, and confirm the change appears after a browser refresh.