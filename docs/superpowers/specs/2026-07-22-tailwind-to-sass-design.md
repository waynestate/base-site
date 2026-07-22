# Remove Tailwind CSS, replace with plain Dart Sass

Date: 2026-07-22

## Context

The base-site frontend currently uses Tailwind CSS v3 (utility-first) alongside hand-authored SCSS. Tailwind is deeply embedded:

- 311 `@apply` calls across ~30 files in `resources/scss/components/`.
- ~55 Blade templates use Tailwind utility classes directly in markup (layout templates, `resources/views/components/*.blade.php`, and `styleguide/Views/*.blade.php`) — see the enumerated list in the implementation plan's Phase C. (An earlier draft undercounted this at ~38 by using a narrow utility-detection grep; see the design note under "Verification" below on why a denylist grep misses much of the utility surface.)
- `tailwind.config.js` defines a customized theme: color scales (`green`, `gold`, `gray`), custom breakpoints (`sm`/`md`/`lg`/`xl`/`2xl`/`3xl`/`mt`), spacing/gutter scale, z-index scale, plus `@tailwindcss/forms` and `@tailwindcss/typography` plugins, and a `safelist` for dynamically-constructed class names (`grid-cols-*`, `colspan-*`, `w-N/N`, `order-*`, `gutter-*`).
- Build wiring: Tailwind runs via PostCSS in the frontend build; `sass` is already in use for the rest of the SCSS pipeline. **Sequencing note:** this migration lands *after* the separate Laravel Mix → Vite migration (`docs/superpowers/specs/2026-07-22-laravel-mix-to-vite-design.md`). By the time this work starts, the build is Vite-based, Tailwind runs through `postcss.config.js`, and there is no `webpack.mix.js` — so the build-tooling changes in step 5 below target the Vite/PostCSS config, not `webpack.mix.js`.
- `@waynestate/wsuheader` / `@waynestate/wsufooter` ship their own pre-built CSS (`dist/header.css`, `dist/footer.css`) and are **not** processed by this app's Tailwind build — out of scope, unaffected.

Decision: move to plain Dart Sass authoring — no utility-first CSS framework — for maintainability and to remove a dependency the team no longer wants.

## Goals

- Remove `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`, and the Tailwind PostCSS step from the build entirely.
- Replace all Tailwind utility-class usage in Blade templates with semantic, component-scoped SCSS classes.
- Replace all 311 `@apply` calls in component SCSS with plain CSS properties.
- Preserve current visual output pixel-for-pixel — this is a refactor of *how* styles are authored, not a redesign.
- Centralize the design tokens currently in `tailwind.config.js` (colors, breakpoints, spacing/gutter scale, z-index) into SCSS variables/maps + mixins as the new single source of truth.

## Non-Goals

- No visual/UX redesign — styling values carry over as-is.
- No change to JS behavior/architecture (slideout, carousel, accordion, tabs, etc.), beyond ensuring the classes it toggles by name still exist.
- No incremental/staged rollout. This ships as a single cutover: Tailwind and its build step are removed in the same change that finishes converting all templates/components (not merged partially with both systems coexisting).

## Design

### 1. Design tokens layer

New `resources/scss/settings/_variables.scss` (or similarly named settings partial, imported first in `main.scss` alongside a `_mixins.scss` and the `_reset.scss` from step 5) becomes the single source of truth, replacing `tailwind.config.js`:

- **Colors** — SCSS maps for `green`, `gold`, `gray` scales, ported verbatim from `baseColors` in `tailwind.config.js`, plus flat variables for one-off colors currently reached via `@apply text-red-600` etc.
- **Breakpoints** — a map mirroring the existing `screens` object (`sm: 420px`, `md: 576px`, `lg: 732px`, `xl: 869px`, `2xl: 1044px`, `3xl: 1200px`, `mt: 780px`, plus the `print` raw media type), consumed through a `respond-to($breakpoint)` mixin (in a `_mixins.scss` settings partial) that replaces Tailwind's `@screen md { }` syntax with `@include respond-to(md) { }`.
- **Spacing/gutter scale** — SCSS variables for `container`, `gutter`, `gutter-xs/sm/md/lg/xl`, replacing the `spacing` theme extension.
- **Z-index scale** — flat variables (`$z-1`…`$z-4`).
- Other one-off `extend` values in the current config (custom `maxWidth`, `dropShadow`, `boxShadow`, `aspectRatio`, `gridTemplateColumns` entries) are ported directly into the specific components that use them rather than centralized, since they're single-purpose, not shared tokens.

`--column-min` / `--column-max` CSS custom properties already defined in `_component-loop.scss` are unrelated to Tailwind and are left as-is.

### 2. Component SCSS migration (`@apply` removal)

Every `@apply` call across `resources/scss/components/*.scss` is converted to its plain CSS equivalent, mechanically, file by file:

- `@apply flex flex-wrap;` → `display: flex; flex-wrap: wrap;`
- `@apply text-green;` → `color: $color-green;` (using the new token variables/maps)
- `@screen md { ... }` → `@include respond-to(md) { ... }`

This step does not change class names or Blade markup — only how each existing class's rules are written.

`@layer` at-rules (native CSS cascade layers, used in `_component-loop.scss`) are valid outside of Tailwind and may be kept if useful for cascade control, or dropped for simplicity. Default: drop them unless a specific layering conflict is found during implementation, since Tailwind's own `base`/`components`/`utilities` layer structure is going away regardless.

### 3. Blade template migration (utility classes → semantic classes)

For the ~38 templates currently using Tailwind utilities directly, each element's utility-class list (e.g. `class="flex items-center justify-between mb-4 md:mb-6"`) is replaced with one semantic class (e.g. `class="promo-header"`), with equivalent rules hand-written into that component's SCSS file — the existing file if the component already has one under `resources/scss/components/`, otherwise a new partial added to the `@import` list in `main.scss`.

**Two deliberate exceptions** stay as small, hand-authored, non-semantic utility classes rather than being folded into per-component classes — both already precedented in the current codebase:

- **Parametric layout classes.** `colspan-1`…`colspan-12`, and the other dynamic patterns currently listed in Tailwind's `safelist` (`grid-cols-*`, `w-N/N`, `order-*`, `gutter-*`, `left-span-*`, `right-span-*`), are driven by CMS-configured column counts and are string-interpolated into `class=""` at render time — they cannot collapse into a fixed semantic class per component. `_component-loop.scss` already hand-defines `.colspan-1`…`.colspan-12` as plain CSS outside Tailwind's generator; this pattern extends to cover the other dynamic patterns currently satisfied by the safelist.
- **JS-toggled state classes.** `.hidden` and `.flex` are referenced directly by class name in `resources/js/modules/slideout.js`, `slideout-main-menu.js`, `carousel.js`, and `accordion.js` (via `classList.add/remove/toggle`). These become two plain global classes (`display: none;` / `display: flex;`) in `_global.scss`, left under their current names rather than renamed, since renaming would require touching JS toggle logic for no benefit.

### 4. Forms & typography plugins

- `@tailwindcss/typography` (`prose` class) — confirmed zero usages anywhere in the codebase. Dropped with no replacement.
- `@tailwindcss/forms` — `_formy.scss` already hand-styles inputs/selects/textareas via `@apply` (converted under step 2); no bare plugin classes (`form-input`, `form-select`, etc.) were found in templates or styleguide views. Dropped, with a final grep pass during implementation to confirm no plugin base-reset behavior (e.g. default appearance resets on native form elements) is silently relied upon before removal.

### 5. Build tooling changes

- **`package.json`** — remove `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`. Keep `postcss`, `autoprefixer`, `sass`.
- **`postcss.config.js`** — remove `tailwindcss` from the PostCSS plugin list; keep `autoprefixer`. (After the Vite migration this list lives in `postcss.config.js`; there is no `webpack.mix.js`.)
- **`vite.config.js`** — remove `tailwind.config.js` from any dev-server watch list, if one was added during the Vite migration.
- **`tailwind.config.js`** — deleted once its `theme` and `safelist` data has been fully ported (design tokens → step 1, dynamic classes → step 3).
- **`main.scss`** — remove `@tailwind base; @tailwind components; @tailwind utilities;`; add imports for the new settings partials (`settings/variables`, `settings/mixins`) near the top, before component imports.
- **`.stylelintrc`** — remove `screen` and `tailwind` (and `layer`, if step 2 drops cascade layers) from `scss/at-rule-no-unknown`'s `ignoreAtRules`, and remove `theme` from `function-no-unknown`'s `ignoreFunctions`, since these are Tailwind-specific allowances no longer needed.
- **Base reset / preflight** — Tailwind's `@tailwind base` (Preflight) currently supplies the browser reset; `main.scss`'s existing top comment says "Combination of normalize and tailwind resets," and `_global.scss` already overrides some Preflight behavior (e.g. placeholder opacity). Preflight's rules are copied verbatim into a new hand-owned `resources/scss/settings/_reset.scss`, imported first in `main.scss` (before the design-token and component partials). Copying it exactly — rather than substituting a different reset library (normalize.css, a minimal custom reset, etc.) — guarantees the pixel-parity goal, since any other reset's rule set (box-sizing, form-element normalization, margin resets) would differ in ways that are each a potential regression. Pruning unused rules is optional future cleanup, not part of this migration.

### 6. Verification / regression risk

This repo has no automated visual regression tooling. Verification for this change relies on:

- `make runtests` (PHPUnit) — verifies logic/data, not visual output.
- `make phplint` / `make stylelint` — formatting only.
- **Manual visual QA is required and is the primary safety net.** The `/styleguide` route enumerates every component and layout combination in the app; each page must be compared against the current `master` (pre-migration) build before merging. This is called out explicitly as a required step in the implementation plan, not optional polish.
- **Completeness gate must be allowlist-based, not denylist-based.** The "have all Tailwind utilities been removed?" check cannot be a grep for a handful of utility prefixes (`flex`, `p-N`, `bg-`, …) — that denylist misses most of the utility surface actually in use here (`font-bold` ~65×, `gap-` ~60×, `relative` ~69×, `text-green`/`text-white`, `opacity-`, `space-y-`, `order-`, `leading-`, `object-`, `z-N`, `italic`, `uppercase`, `text-2xl`, `rounded-full`, …), so a file styled only with e.g. `text-2xl text-white uppercase` would pass the check while still carrying utilities. The final "zero utilities remain" verification (and the file-discovery grep that drives Phase C) must instead **enumerate the known-good class vocabulary** (semantic component classes, the JS-toggled/single-property globals from step 3, and the dynamic/parametric classes) and flag any `class=""` token outside it. See the corresponding tasks in the implementation plan.

## Risks / things to watch during implementation

- **Missing Preflight reset** — mitigated by copying Preflight verbatim into `_reset.scss` (see step 5), but still worth a deliberate check during QA that the copied reset is actually imported first, ahead of any component styles that might otherwise be overridden by it.
- **`@tailwindcss/forms` implicit resets** — verify no native form element relies on the plugin's default styling before removing it (see step 4).
- **Safelist parity** — every pattern in the current `tailwind.config.js` `safelist` must have a corresponding hand-authored class before `tailwind.config.js` is deleted, or dynamically-rendered CMS layouts will silently lose styling with no build-time error to catch it.
- Since this is a big-bang cutover (no incremental coexistence period), the working branch will be in a partially-converted, visually-broken state until the migration is complete — plan for this to land as one large PR reviewed via the styleguide QA pass described above, not merged in slices.