# Migrate Build Tooling from Laravel Mix to Vite — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace Laravel Mix (webpack) with Vite + `laravel-vite-plugin` for the base-site frontend, preserving today's compiled output, the custom `public/_resources/` output path, cache-busting, and every ancillary build step — with **no** changes to CSS/JS authoring and **no** Tailwind removal (that is a separate follow-up).

**Architecture:** Vite compiles the two existing entries (`resources/scss/main.scss`, `resources/js/main.js`) into `public/_resources/` via `laravel-vite-plugin`'s `buildDirectory: '_resources'`. PostCSS (`tailwindcss` + `autoprefixer`) moves from `webpack.mix.js` into a standalone `postcss.config.js` — this is what lets the follow-up Tailwind-removal plan delete one line instead of touching bundler config. All non-compile work currently inlined in `webpack.mix.js` (generating header/footer/error Blade files, the footer-year rewrite, copying error CSS/PNG + fonts + images, the `_static` symlink, and the git pre-commit hook install) moves to a `scripts/prepare-assets.mjs` script run before every build. Blade loads assets via `@vite()` reading `manifest.json`. The dev workflow is `vite build --watch` with polling (no Vite dev server, no HMR).

**Tech Stack:** Vite, `laravel-vite-plugin`, Dart Sass (`sass`), PostCSS + Autoprefixer, Node 26.x (CI), Laravel 13, Blade.

**Spec:** `docs/superpowers/specs/2026-07-22-laravel-mix-to-vite-design.md`

**Sequencing:** This lands **before** the Tailwind → Sass migration (`docs/superpowers/plans/2026-07-22-tailwind-to-sass-plan.md`). Tailwind stays fully intact here.

---

## Key facts captured during planning (verify before relying on any that may have drifted)

- App is Laravel 13 (`laravel/framework: ^13.20`); `package.json` `name` is `base` → dev host is `base.wayne.localhost`.
- Current outputs: `resources/js/main.js` → `public/_resources/js/main.js`; `resources/scss/main.scss` → `public/_resources/css/main.css`. Blade references both via `mix()` in `resources/views/layouts/main.blade.php` (lines 9 and 95).
- **`public/_resources/` is shared:** Mix writes compiled CSS/JS there **and** copies fonts (`public/_resources/fonts`), images (`public/_resources/images`), and error CSS/maps/PNGs (`public/_resources/css`, `public/_resources/images`) there. Vite must not wipe those copies — see Task 3 (`emptyOutDir`) and Task 5 (copy ordering).
- `webpack.mix.js` ancillary work: generates `resources/views/components/{header,footer}.blade.php` from `@waynestate/wsuheader`/`wsufooter` `dist/*.html`; generates `resources/views/errors/{404,403,429,500}.blade.php` from `vendor/waynestate/error-*/dist/*.php`; rewrites the footer's year to `{{ date('Y') }}`; copies error CSS/`.map`/PNG, fonts, images; creates the `public/_static` → `storage/app/public` symlink; installs `hooks/pre-commit` (dev only).
- `package.json` scripts today: `development: mix`, `watch: mix watch`, `watch-poll: mix watch -- --watch-options-poll=1000`, `production: mix --production`, `lint`/`lint:fix` (ESLint, standalone — already independent of the bundler).
- There is a `"laravel-mix": { ... }` config key in `package.json` (around line 64) in addition to the `laravel-mix` devDependency — remove both.
- `Makefile`: `MIXFILE := webpack.mix.js`; `webpackdev`→`npm run development`, `webpackprod`→`npm run production`, `watch`→`npm run watch-poll`.
- CI (`.github/workflows/build.yml`, Node 26.x) runs `make build` (→ `npm run development`).

---

## File Structure

New files:
- `vite.config.js` — Vite + `laravel-vite-plugin` config (entries, `buildDirectory: '_resources'`, `build.watch` polling, `emptyOutDir: false`).
- `postcss.config.js` — PostCSS plugins (`tailwindcss` + `autoprefixer`), extracted from `webpack.mix.js`.
- `scripts/prepare-assets.mjs` — all ancillary (non-compile) work moved out of `webpack.mix.js`.

Modified files:
- `resources/views/layouts/main.blade.php` — `mix(...)` → `@vite([...])`.
- `package.json` — swap scripts, add/remove devDependencies, drop the `laravel-mix` config block.
- `Makefile` — `MIXFILE` → the Vite config; watch target → the new polling script.
- Possibly `app/Providers/AppServiceProvider.php` (or a config) — set the PHP-side Vite build directory to `_resources` if `@vite` doesn't otherwise resolve it (Task 6).

Deleted files:
- `webpack.mix.js` (only after everything above works and produces equivalent output).

---

## Phase A: Stand up Vite alongside Mix

The goal of Phase A is a Vite build that produces output equivalent to Mix, **without removing Mix yet** — so you can diff the two. Mix stays wired up and runnable until Phase E.

### Task 1: Install Vite dependencies

**Files:**
- Modify: `package.json`

- [ ] **Step 1: Add Vite deps**

Run: `yarn add -D vite laravel-vite-plugin vite-plugin-static-copy`
(`vite-plugin-static-copy` is used in Task 4/5 for the asset copies; skip it only if you fold all copies into `scripts/prepare-assets.mjs` with `fs` instead.)

- [ ] **Step 2: Confirm install**

Run: `yarn install` — expected: lockfile updates, no errors. Do **not** remove `laravel-mix` yet.

- [ ] **Step 3: Commit**

```bash
git add package.json yarn.lock
git commit -m "chore: add vite, laravel-vite-plugin, static-copy (alongside mix)"
```

### Task 2: Extract PostCSS config

**Files:**
- Create: `postcss.config.js`

- [ ] **Step 1: Create `postcss.config.js`** mirroring the current Mix `postCss` array (`tailwindcss` + `autoprefixer`, in that order):

```js
module.exports = {
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
    ],
};
```

(Tailwind stays — this is the Vite migration, not the Tailwind removal. The follow-up plan deletes the `tailwindcss` line here.)

- [ ] **Step 2: Commit**

```bash
git add postcss.config.js
git commit -m "chore: extract PostCSS (tailwind + autoprefixer) into postcss.config.js"
```

### Task 3: Create `vite.config.js`

**Files:**
- Create: `vite.config.js`

- [ ] **Step 1: Write the config**

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/main.scss', 'resources/js/main.js'],
            // Keep the current custom output path (spec §3). Assets + manifest
            // land in public/_resources/ and @vite() resolves /_resources/...
            buildDirectory: '_resources',
            refresh: false, // no dev server / HMR (spec §6)
        }),
    ],
    build: {
        // CRITICAL: public/_resources/ also holds COPIED assets (fonts, images,
        // error CSS). Do NOT let Vite empty it, or those copies get wiped.
        emptyOutDir: false,
        // Match Mix's sourceMaps()
        sourcemap: true,
        // Polling watch build for Docker bind mounts (spec §6). Vite ignores
        // `watch` unless invoked with `vite build --watch`.
        watch: {
            include: ['resources/**'],
            chokidar: { usePolling: true, interval: 500 },
        },
    },
});
```

- [ ] **Step 2: Verify `buildDirectory` and `emptyOutDir` assumptions against the installed versions**

`laravel-vite-plugin` and Vite APIs evolve — before trusting the config, run a one-off build (Task 7) and confirm: (a) hashed assets + `manifest.json` actually land under `public/_resources/`, and (b) previously-copied fonts/images/error-CSS in `public/_resources/` are still present afterward. If `buildDirectory` isn't honored or the chokidar option name differs, consult the installed plugin/Vite docs and adjust. Do not proceed to Phase E until both hold.

- [ ] **Step 3: Commit**

```bash
git add vite.config.js
git commit -m "feat: add vite.config.js (keeps _resources output, polling watch, no dir-empty)"
```

---

## Phase B: Port the ancillary (non-compile) Mix work

### Task 4: Create `scripts/prepare-assets.mjs`

Move everything `webpack.mix.js` does **other than compile JS/CSS** into a standalone Node script. Port each block faithfully from the current `webpack.mix.js`.

**Files:**
- Create: `scripts/prepare-assets.mjs`

- [ ] **Step 1: Port each block** (read the current `webpack.mix.js` and reproduce exactly):
  - `fs.copyFileSync(...)` of `@waynestate/wsuheader/dist/header.html` → `resources/views/components/header.blade.php`, `@waynestate/wsufooter/dist/footer.html` → `.../footer.blade.php`, and the four `vendor/waynestate/error-*/dist/*.php` → `resources/views/errors/*.blade.php`.
  - The **footer-year rewrite** (`footerContent.replace(/2\d{3}/g, "{{ date('Y') }}")`).
  - The **dev-only** `hooks/pre-commit` → `.git/hooks/pre-commit` install (guard on an env flag or `process.env.NODE_ENV !== 'production'` — Mix used `!mix.inProduction()`).
  - The `public/_static` → `storage/app/public` symlink (idempotent; ignore `EEXIST`, as the current code does with `errno != -17`).
  - **Static copies** (error CSS/`.map`, error PNGs, fonts, images) → the same `public/_resources/{css,images,fonts}` destinations. Either do these here with `fs.cpSync`, or leave them to `vite-plugin-static-copy` in Task 5 — pick one home and keep it consistent (this plan uses `vite-plugin-static-copy` in Task 5, so copies can be omitted here; the Blade generation, footer rewrite, symlink, and git hook stay here).

- [ ] **Step 2: Make it runnable standalone**

Run: `node scripts/prepare-assets.mjs`
Expected: regenerates the header/footer/error Blade files, rewrites the footer year, creates the symlink (or no-ops if present), installs the git hook. Confirm each file exists / is updated. `git status` should show the generated Blade files as unchanged if they were already current (they're gitignored or committed as generated — match current repo behavior; do not commit newly-generated copies if the repo treats them as build artifacts).

- [ ] **Step 3: Commit**

```bash
git add scripts/prepare-assets.mjs
git commit -m "feat: move Mix ancillary steps (blade gen, footer year, symlink, git hook) to prepare-assets.mjs"
```

### Task 5: Wire static asset copies into Vite

**Files:**
- Modify: `vite.config.js`

- [ ] **Step 1: Add `vite-plugin-static-copy`** to replicate Mix's `.copy()`/`.copyDirectory()` targets (error CSS/`.map`/PNG, fonts, images) into `public/_resources/...`:

```js
import { viteStaticCopy } from 'vite-plugin-static-copy';
// ...in plugins: [ ... ]
viteStaticCopy({
    targets: [
        { src: 'vendor/waynestate/error-*/dist/*.css', dest: '_resources/css' },
        { src: 'vendor/waynestate/error-*/dist/*.css.map', dest: '_resources/css' },
        { src: 'vendor/waynestate/error-*/dist/*.png', dest: '_resources/images' },
        { src: 'resources/fonts/**/*', dest: '_resources/fonts' },
        { src: 'resources/images/**/*', dest: '_resources/images' },
    ],
}),
```

(Confirm the exact source globs against the current `webpack.mix.js` `.copy(...)` arrays — they enumerate specific error files. Because `emptyOutDir: false` is set in Task 3, these copies survive the compiled-asset write regardless of plugin ordering.)

- [ ] **Step 2: Build and verify copies land**

Run: `node scripts/prepare-assets.mjs && yarn vite build`
Expected: `public/_resources/{css,fonts,images}` contain the copied error CSS, fonts, and images **and** the newly compiled hashed CSS/JS + `manifest.json`.

- [ ] **Step 3: Commit**

```bash
git add vite.config.js
git commit -m "feat: replicate Mix static-asset copies via vite-plugin-static-copy"
```

---

## Phase C: Blade + Laravel integration

### Task 6: Point Blade at Vite

**Files:**
- Modify: `resources/views/layouts/main.blade.php`
- Possibly modify: `app/Providers/AppServiceProvider.php`

- [ ] **Step 1: Replace the `mix()` calls**

In `resources/views/layouts/main.blade.php`, replace:
```blade
<link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">   {{-- line 9 --}}
...
<script src="{{ mix('_resources/js/main.js') }}"></script>            {{-- line 95 --}}
```
with a single directive in the `<head>` (Vite emits both the stylesheet link and the script tag):
```blade
@vite(['resources/scss/main.scss', 'resources/js/main.js'])
```
Remove the old `<script>` at line 95. Confirm the resulting tag order/placement matches the current head/body-end placement closely enough (Vite injects the script as a module; verify nothing depends on the script being a classic, non-module tag at end-of-body — `resources/js/main.js` is already ES-module `import` based, so a module script is correct).

- [ ] **Step 2: Make the PHP side resolve `_resources`**

The Blade `@vite` runtime must read the manifest from `public/_resources/` (not the default `public/build/`). Verify how the installed Laravel version wires this — if `@vite` 404s the manifest, set the build directory on the PHP side, e.g. in `AppServiceProvider::boot()`:
```php
\Illuminate\Support\Facades\Vite::useBuildDirectory('_resources');
```
Only add this if `@vite` doesn't already resolve `/_resources/...` from the `laravel-vite-plugin` `buildDirectory` alone. Confirm by loading a page and checking the rendered `<link>`/`<script>` `src` is `/_resources/...` and returns 200.

- [ ] **Step 3: Build and load the app**

Run: `node scripts/prepare-assets.mjs && yarn vite build`, then load `https://base.wayne.localhost/` and `/styleguide`.
Expected: styles and JS load from `/_resources/...`; the page renders identically to a `master` (Mix) build. Exercise the JS-driven UI (slideout menu, carousel, accordion, tabs) to confirm `main.js` executed.

- [ ] **Step 4: Commit**

```bash
git add resources/views/layouts/main.blade.php app/Providers/AppServiceProvider.php
git commit -m "refactor: load assets via @vite from _resources (replaces mix() helper)"
```

---

## Phase D: Scripts, Makefile, dev workflow

### Task 7: Update npm scripts

**Files:**
- Modify: `package.json`

- [ ] **Step 1: Replace the Mix scripts** with Vite equivalents; keep `lint`/`lint:fix`/`phpstan*` untouched. Run the prepare script before each build via `pre*` hooks:

```json
"scripts": {
    "prepare-assets": "node scripts/prepare-assets.mjs",
    "prebuild": "npm run prepare-assets",
    "build": "vite build",
    "development": "npm run build",
    "dev": "npm run build",
    "preproduction": "npm run prepare-assets",
    "production": "vite build --mode production",
    "prod": "npm run production",
    "prewatch": "npm run prepare-assets",
    "watch": "vite build --watch",
    "watch-poll": "vite build --watch",
    "lint": "eslint resources/js/**/*.js",
    "lint:fix": "eslint resources/js/**/*.js --fix",
    "phpstan": "make phpstan",
    "phpstan:dry": "make phpstandry"
}
```

(Keep the `development`/`production`/`watch-poll` names so the `Makefile` targets keep working. Polling is configured in `vite.config.js` (`build.watch.chokidar.usePolling`), so `watch` and `watch-poll` can be identical; set `CHOKIDAR_USEPOLLING=true` in the container env if watching still misses changes.)

- [ ] **Step 2: Verify each script**

Run: `npm run build`, `npm run production`, and briefly `npm run watch` (Ctrl-C after confirming it enters watch mode). Expected: all compile to `public/_resources/`; the `pre*` hook runs `prepare-assets` first each time.

- [ ] **Step 3: Commit**

```bash
git add package.json
git commit -m "chore: replace mix npm scripts with vite build/watch + prepare-assets hooks"
```

### Task 8: Update the Makefile

**Files:**
- Modify: `Makefile`

- [ ] **Step 1: Repoint `MIXFILE` and the file-dependency prereqs**

Change `MIXFILE := webpack.mix.js` to reference the Vite config (e.g. `VITEFILE := vite.config.js`) and update the `webpackdev`/`webpackprod`/`watch` target prerequisites from `$(MIXFILE)` to the new variable (or drop the prereq). The target **bodies** already call `npm run development` / `npm run production` / `npm run watch-poll`, which now invoke Vite — so `make build`, `make buildproduction`, and `make watch` keep working by name without changing CI or the README. Rename the targets from `webpack*` to `vite*` only if you also update their references in the `build:`/`buildproduction:` aliases.

- [ ] **Step 2: Verify**

Run: `make build` then `make buildproduction`. Expected: both succeed and write to `public/_resources/`.

- [ ] **Step 3: Commit**

```bash
git add Makefile
git commit -m "chore: point Makefile build targets at Vite"
```

---

## Phase E: Remove Laravel Mix

Only start this once Phases A–D are complete, a `make build` produces output equivalent to `master`, and the app renders correctly from `/_resources/`.

### Task 9: Delete Mix config and dependencies

**Files:**
- Delete: `webpack.mix.js`
- Modify: `package.json`

- [ ] **Step 1: Delete `webpack.mix.js`**

```bash
rm webpack.mix.js
```

- [ ] **Step 2: Remove Mix + webpack-only devDependencies from `package.json`**

Remove `laravel-mix`, `eslint-webpack-plugin`, and `sass-loader` (Vite compiles Sass via the `sass` package directly). Also remove the standalone `"laravel-mix": { ... }` config block (around line 64). Keep `sass`, `postcss`, `postcss-scss`, `autoprefixer`, `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`.

Before removing `sass-loader`, confirm nothing else references it:
Run: `grep -rn "sass-loader\|eslint-webpack-plugin\|laravel-mix" --include="*.js" --include="*.json" . --exclude-dir=node_modules`
Expected: no references outside `package.json`/`yarn.lock`.

- [ ] **Step 3: Reinstall**

Run: `yarn install`
Expected: lockfile updates, no errors.

- [ ] **Step 4: Full build + checks**

Run: `make build && make phplint && make stylelint && make runtests && make eslint`
Expected: all pass.

- [ ] **Step 5: Commit**

```bash
git add package.json yarn.lock
git rm webpack.mix.js
git commit -m "chore: remove laravel-mix, sass-loader, eslint-webpack-plugin, and webpack.mix.js"
```

---

## Phase F: Verification

### Task 10: Output parity, ancillary integrity, CI, and dev smoke test

**Files:** none (verification only)

- [ ] **Step 1: Compiled-output parity vs `master`**

Build on this branch and on a clean `master` (Mix) checkout and compare the compiled CSS/JS. The exact hashed filenames will differ; compare the **content**: normalize (e.g. strip the sourcemap comment / hash) and diff `main.css` and `main.js`. They should be functionally identical (same Sass + Tailwind + autoprefixer output). Investigate any non-trivial diff before proceeding.

- [ ] **Step 2: Ancillary integrity**

After a clean `make build`, confirm all of these exist and are current:
- `resources/views/components/header.blade.php`, `.../footer.blade.php` (generated), footer year rendered as `{{ date('Y') }}`.
- `resources/views/errors/{404,403,429,500}.blade.php` (generated).
- `public/_resources/css/{404,403,429,500}.css` (+ `.map`), `public/_resources/images/*.png`, `public/_resources/fonts/**`, `public/_resources/images/**` (copied assets **not** wiped by the Vite build).
- `public/_static` symlink → `storage/app/public`.
- `manifest.json` under `public/_resources/`, and `@vite` URLs resolve to 200.

- [ ] **Step 3: CI-equivalent sequence** (matches `.github/workflows/build.yml`, Node 26.x)

```bash
make yarn
make composerinstalldev
make build
make generatekey
make phplintdry
make stylelint
make runtests
```
Expected: every step passes.

- [ ] **Step 4: Dev watch smoke test (polling)**

Inside the `base` container, run `make watch`. Edit a rule in a `.scss` file and a line in a `.js` module; confirm Vite rebuilds `public/_resources/` on each save (polling picks up the change), and the change appears at `https://base.wayne.localhost/` after a manual browser refresh. (No HMR / auto-reload is expected — spec §6.)

- [ ] **Step 5: Confirm no Mix/webpack references remain**

Run: `grep -rniE "laravel-mix|webpack|mix\(|browsersync" --include="*.js" --include="*.json" --include="*.php" . --exclude-dir=node_modules --exclude-dir=vendor --exclude-dir=docs`
Expected: no output (the `mix()` Blade helper and all Mix/webpack config are gone).

- [ ] **Step 6: Deploy-tooling review**

Read `Envoy.blade.php` / the `make deploy*` targets and confirm the deploy build step invokes the Vite build (`make buildproduction`) and that nothing assumes `webpack.mix.js`, `mix-manifest.json`, or Mix-specific artifacts. The output path is unchanged (`public/_resources/`), so path assumptions hold; only the build invocation changed. Note any required deploy change for the reviewer (deploy-server changes are out of band from this repo).

- [ ] **Step 7: Sign-off**

No code changes expected here if all above passed. If parity diffs or missing-asset issues were found and fixed, commit them individually per the task templates above before considering the migration complete.