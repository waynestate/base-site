# Remove Tailwind CSS, Replace with Plain Dart Sass — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove Tailwind CSS v3 (and its plugins/build step) from the base-site frontend and replace every utility-class usage with hand-authored, semantic SCSS — with zero visual regressions.

**Architecture:** A new `resources/scss/settings/` layer (`_reset.scss`, `_variables.scss`, `_mixins.scss`) replaces `tailwind.config.js` as the single source of design tokens and provides the Preflight-equivalent browser reset. Every `@apply`/`@screen` call in existing component SCSS is mechanically translated to plain CSS using the token layer. Every Blade template that uses inline Tailwind utility classes gets a new semantic class, with the actual rules written into that component's SCSS file. Tailwind itself (config, packages, PostCSS step) is only removed at the very end, after everything has a hand-authored equivalent — this keeps the build compiling and comparable throughout the migration even though the *merged* result is a single, non-incremental cutover per the spec.

**Tech Stack:** Vite, Dart Sass (`sass`), PostCSS + Autoprefixer (kept), Stylelint (`stylelint-config-standard-scss`), Blade.

**Prerequisite:** This plan runs **after** the Laravel Mix → Vite migration (`docs/superpowers/specs/2026-07-22-laravel-mix-to-vite-design.md`) has landed. By the time this executes, the build is Vite-based: Tailwind runs through `postcss.config.js`, there is no `webpack.mix.js`, and Blade loads assets via `@vite()`. The build-tooling tasks below (Phase F) therefore edit `postcss.config.js`/`vite.config.js`, not `webpack.mix.js`. If this plan is somehow executed before the Vite migration, stop and sequence Vite first.

**Spec:** `docs/superpowers/specs/2026-07-22-tailwind-to-sass-design.md`

---

## File Structure

New files:
- `resources/scss/settings/_reset.scss` — hand-owned copy of Tailwind's Preflight CSS output (verbatim, no dependency on Tailwind at runtime).
- `resources/scss/settings/_variables.scss` — SCSS maps/variables for colors, breakpoints, spacing/gutter scale, z-index (replaces `tailwind.config.js` theme).
- `resources/scss/settings/_mixins.scss` — `respond-to($breakpoint)` mixin (replaces Tailwind's `@screen`).
- `resources/scss/components/_breadcrumbs.scss` — new semantic component file for the breadcrumbs nav (currently styled entirely via inline utilities).
- Additional new component `.scss` files as needed, one per Blade template that doesn't already have a matching component file (created inline in that template's task, not listed exhaustively here — see Phase C).

Modified files:
- `resources/scss/main.scss` — import the new settings layer; eventually drop `@tailwind base/components/utilities`.
- All ~27 files in `resources/scss/components/` and `resources/scss/partials/` that currently use `@apply`/`@screen`.
- ~53 Blade templates (`resources/views/**/*.blade.php`, `styleguide/Views/**/*.blade.php`) that use inline Tailwind utility classes.
- `postcss.config.js` — drop the `tailwindcss` PostCSS plugin (keep `autoprefixer`).
- `vite.config.js` — remove the `tailwind.config.js` dev-server watch entry, if one exists.
- `package.json` — remove `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`.
- `.stylelintrc` — remove Tailwind-specific at-rule/function allowances.

Deleted files:
- `tailwind.config.js` (only after every token and safelist pattern has a hand-authored equivalent).

---

## Appendix A: Tailwind → CSS Translation Reference

Every task below that converts `@apply`/`@screen` or inline utility classes must resolve tokens using this reference. It is scoped to exactly the tokens actually used in this codebase (337 distinct tokens found via `grep -roE "@apply [^;]+;" resources/scss -r`), not the full Tailwind utility set.

### A.1 Design tokens (also encoded as real SCSS in Task 3)

**Colors** (final resolved hex values — `baseColors` in `tailwind.config.js` plus Tailwind's default `zinc`/`red` scales where not overridden):

| Token | Hex | Token | Hex |
|---|---|---|---|
| black | `#09090b` | green-500 | `#0b4a40` |
| white | `#ffffff` | green-600 | `#094038` |
| gray-100 | `#f4f4f5` | green-700 | `#08352f` |
| gray-200 | `#e4e4e7` | green-800 | `#062b27` |
| gray-300 | `#d4d4d8` | green-900 | `#05211e` |
| gray-400 / DEFAULT | `#a1a1aa` | gold-100 | `#ffebad` |
| gray-500 | `#71717a` | gold-200 | `#ffe085` |
| green-50 | `#cedddb` | gold-400 / DEFAULT | `#ffcc33` |
| green-100 | `#9ebbb6` | gold-500 | `#edbd2c` |
| green-400 / DEFAULT | `#0c5449` | red-50 | `#fef2f2` |
| red-300 | `#fca5a5` | red-600 | `#dc2626` |

`green-600/70` (Tailwind opacity modifier) → `rgba(9, 64, 56, 0.7)`.

Use these as SCSS variables/map lookups from Task 3 (e.g. `$color-green`, `map.get($colors, 'green', 600)`) — do not hardcode hex a second time in component files.

**Breakpoints** (`min-width`, from `tailwind.config.js` `screens`):

| Name | Value | Name | Value |
|---|---|---|---|
| sm | 420px | xl | 869px |
| md | 576px | 2xl | 1044px |
| lg | 732px | 3xl | 1200px |
| mt | 780px | print | `@media print` |

**Spacing scale** (Tailwind default `rem` scale, root 16px, plus this project's custom overrides):

| Key | Value | Key | Value | Key | Value |
|---|---|---|---|---|---|
| 0 | 0 | 3 | 0.75rem | 10 | 2.5rem |
| px | 1px | 3.5 | 0.875rem | 12 | 3rem |
| 0.5 | 0.125rem | 4 | 1rem | 16 | 4rem |
| 1 | 0.25rem | 5 | 1.25rem | 17 *(custom)* | 4.25rem |
| 1.5 | 0.375rem | 6 | 1.5rem | 19 *(custom)* | 4.75rem |
| 2 | 0.5rem | 8 | 2rem | 32 | 8rem |
| 2.5 | 0.625rem | | | | |

Custom `spacing` extend: `container` / `container-lg` → `max(1rem, (100% - 73rem) / 2)`; `gutter` → `2rem`; `gutter-xs` → `0.5rem`; `gutter-sm` → `1rem`; `gutter-md` → `3rem`; `gutter-lg` → `4rem`; `gutter-xl` → `5rem`.

**Z-index:** `z-1`–`z-4` are this project's custom scale (`1`–`4`); `z-10`/`z-40`/`z-50` are Tailwind's core defaults (`10`/`40`/`50`). `z-[10]` (arbitrary) = `10`. Negative (`-z-10`) = `-10`.

**Custom one-off values** (ported directly into the component that uses them, not centralized): `max-w-half` → `50%`; `max-w-screen-3xl` → `1200px`; `pb-16/9` → `56.35%`; `padding: hero` → `36.3%`; `height/min-height: hero` → `600px` (max) / `36.25vw` (height/min-height); `height/min-height: hero-small` → `20.83vw`; `max-height: hero-small` → `250px`; `border-l-12` → `12px` width; `drop-shadow-px` → `filter: drop-shadow(0 1px 1px rgba(5, 33, 30, 0.5))`; `drop-shadow-2px` → `filter: drop-shadow(0 2px 1px rgba(5, 33, 30, 0.5))`; `shadow-white` → `box-shadow: 0 7px 0 #fff, 0 14px 0 #fff`; `shadow-gray` → `box-shadow: 0 7px 0 <gray-400>, 0 14px 0 <gray-400>`; `opacity-65` → `.65`; `aspect-portrait` → `3 / 4`; `aspect-hero` → `2.76 / 1`; `aspect-hero-small` → `22 / 5`.

### A.2 Structural / layout utilities

| Utility | CSS |
|---|---|
| `block` / `inline` / `inline-block` / `flex` / `inline-grid` / `grid` / `table` / `table-caption` / `hidden` | `display: <same word>` (`hidden` → `display: none`) |
| `absolute` / `relative` / `fixed` | `position: <same word>` |
| `inset-0` | `inset: 0` |
| `top-0` / `bottom-0` / `left-0` / `right-0` | `top/bottom/left/right: 0` |
| `bottom-auto` | `bottom: auto` |
| `flex-col` / `flex-row` / `flex-row-reverse` | `flex-direction: column / row / row-reverse` |
| `flex-wrap` | `flex-wrap: wrap` |
| `items-center` / `items-end` / `items-start` / `items-stretch` | `align-items: center / flex-end / flex-start / stretch` |
| `justify-between` / `justify-center` / `justify-end` / `justify-start` | `justify-content: space-between / center / flex-end / flex-start` |
| `self-center` | `align-self: center` |
| `grow-0` | `flex-grow: 0` |
| `shrink-0` | `flex-shrink: 0` |
| `gap-4` / `gap-6` | `gap: 1rem` / `1.5rem` |
| `md:space-x-4` | `> * + * { margin-left: 1rem; }` (Tailwind's `space-x` uses this child-combinator pattern — wrap in `@include respond-to(md)`) |
| `grid-cols-1` / `md:grid-cols-2` / `lg:grid-cols-3` | `grid-template-columns: repeat(1/2/3, minmax(0, 1fr))` |
| `auto-rows-auto` | `grid-auto-rows: auto` |
| `col-start-1` / `col-start-2` | `grid-column-start: 1 / 2` |
| `col-end-auto` | `grid-column-end: auto` |
| `row-span-2` | `grid-row: span 2 / span 2` |
| `overflow-auto` / `hidden` / `visible` / `x-auto` / `x-scroll` | `overflow(-x): auto / hidden / visible / auto / scroll` |
| `box-border` | `box-sizing: border-box` |
| `float-left` / `float-none` | `float: left / none` |
| `cursor-pointer` | `cursor: pointer` |

### A.3 Sizing (uses spacing scale above unless noted)

`w-`, `h-`, `min-h-`, `max-h-`, `max-w-`, `mt-`, `mb-`, `ml-`, `mr-`, `mx-`, `my-`, `m-`, `p-`, `px-`, `py-`, `pt-`, `pb-`, `pl-`, `pr-` all map directly to the matching CSS property (`width`, `height`, `min-height`, `max-height`, `max-width`, `margin-top`, `margin-bottom`, `margin-left`, `margin-right`, `margin-left`+`margin-right`, `margin-top`+`margin-bottom`, `margin`, `padding`, `padding-left`+`padding-right`, `padding-top`+`padding-bottom`, `padding-top`, `padding-bottom`, `padding-left`, `padding-right`) using the spacing scale in A.1. `auto` → `auto`. `full` → `100%`. Fractions: `w-1/2`→`50%`, `w-1/3`→`33.333333%`, `w-2/3`→`66.666667%`, `w-2/5`→`40%`, `w-1/4`→`25%`, `w-4/5`→`80%`. Negative prefix (`-mt-0.5`) negates the resolved value (`-0.125rem`). Arbitrary bracket values (`w-[60%]`, `max-h-[250px]`, `min-h-[135px]`, `top-[60%]`, `-top-[60%]`) pass through literally as the CSS value (negate for the `-` prefix).

### A.4 Typography

| Utility | CSS |
|---|---|
| `text-sm` | `font-size: 0.875rem; line-height: 1.25rem;` |
| `text-base` | `font-size: 1rem; line-height: 1.5rem;` |
| `text-lg` | `font-size: 1.125rem; line-height: 1.75rem;` |
| `text-xl` | `font-size: 1.25rem; line-height: 1.75rem;` |
| `text-2xl` | `font-size: 1.5rem; line-height: 2rem;` |
| `text-3xl` | `font-size: 1.875rem; line-height: 2.25rem;` |
| `text-4xl` | `font-size: 2.25rem; line-height: 2.5rem;` |
| `text-5xl` | `font-size: 3rem; line-height: 1;` |
| `font-black` / `bold` / `light` / `normal` | `font-weight: 900 / 700 / 300 / 400` |
| `font-mono` / `serif` / `sans` | `font-family:` per `tailwind.config.js` `fontFamily` (copy the exact stacks into `_variables.scss` in Task 3) |
| `italic` / `not-italic` | `font-style: italic / normal` |
| `uppercase` / `normal-case` | `text-transform: uppercase / none` |
| `underline` / `no-underline` | `text-decoration-line: underline / none` |
| `leading-3` / `none` / `normal` / `tight` | `line-height: 0.75rem / 1 / 1.5 / 1.25` |
| `tracking-wide` | `letter-spacing: 0.025em` |
| `whitespace-pre-wrap` | `white-space: pre-wrap` |
| `text-left` / `center` / `right` | `text-align: left / center / right` |
| `align-middle` / `align-top` | `vertical-align: middle / top` |
| `list-circle` / `square` / `decimal` / `disc` / `lower-alpha` / `lower-roman` | `list-style-type: circle / square / decimal / disc / lower-alpha / lower-roman` |

### A.5 Borders

The copied Preflight reset (Task 2) sets a global default `border-style: solid; border-color: #e4e4e7;` on `*, ::before, ::after`. Because of that, bare width utilities only need to set `border-*-width` — style/color are already defaulted:

| Utility | CSS |
|---|---|
| `border` | `border-width: 1px` |
| `border-0` | `border-width: 0` |
| `border-t` / `border-b` | `border-top-width: 1px` / `border-bottom-width: 1px` |
| `border-t-0` / `border-b-0` | `border-top-width: 0` / `border-bottom-width: 0` |
| `border-t-8` / `border-b-4` / `border-l-12` | `border-top-width: 2rem` / `border-bottom-width: 1rem` / `border-left-width: 12px` (custom) |
| `border-solid` | `border-style: solid` (redundant with reset default; keep only if the selector needs to override a more specific rule) |
| `border-collapse` | `border-collapse: collapse` |
| `border-{color}` (e.g. `border-gray-400`, `border-green-700`, `border-b-gray-300`) | `border-color:` / `border-bottom-color:` using A.1 color table |

### A.6 Backgrounds, effects, misc

| Utility | CSS |
|---|---|
| `bg-{color}` | `background-color:` via A.1 |
| `bg-transparent` / `bg-none` | `background-color: transparent` / `background-image: none` |
| `bg-no-repeat` | `background-repeat: no-repeat` |
| `bg-center` | `background-position: center` |
| `bg-[length:50%]` / `md:bg-[length:100px]` | `background-size: 50%` / `100px` |
| `rounded` / `rounded-sm` / `rounded-full` / `rounded-none` | `border-radius: 0.25rem / 0.125rem / 9999px / 0` |
| `opacity-N` | `opacity: N/100` (e.g. `opacity-20` → `.2`) |
| `mix-blend-normal` | `mix-blend-mode: normal` |
| `object-cover` / `contain` / `center` | `object-fit: cover / contain` / `object-position: center` |
| `fill-current` | `fill: currentColor` |
| `transition-all` | `transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms;` |
| `transition-colors` | `transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;` (+ same default timing/duration) |
| `duration-500` | `transition-duration: 500ms` (overrides the 150ms default when combined with a `transition-*` utility) |
| `outline` | `outline-style: solid` |
| `outline-0` / `outline-2` | `outline-width: 0 / 2px` |
| `outline-{color}` (e.g. `outline-green`) | `outline-color:` via A.1 |
| `outline-offset-[-2px]` | `outline-offset: -2px` |

### A.7 State variants and prefixes

- `hover:`, `focus:`, `focus-visible:`, `focus-within:` → wrap the resolved declaration(s) in `&:hover { }`, `&:focus { }`, `&:focus-visible { }`, `&:focus-within { }`.
- `group-hover:opacity-100` → requires the ancestor element carrying Tailwind's `class="group"` marker. Check the Blade template being converted for that ancestor; translate to `.<parent-semantic-class>:hover .<child-semantic-class> { opacity: 1; }` (nest under the parent selector, not a bare `&:hover`).
- Responsive prefixes (`sm:`, `md:`, `lg:`, `xl:`, `2xl:`, `3xl:`, `mt:`) → wrap in `@include respond-to(<name>) { }` (mixin from Task 4).
- `print:` → wrap in `@media print { }`.
- Trailing `!important` on an `@apply` line (e.g. `@apply text-base !important;`) → append `!important` to every resolved declaration from that line.

### A.8 Project-defined "utilities" (not real Tailwind utilities — do not look these up above)

`row`, `white-links`, and `content` are this project's own classes (defined in `_row.scss`, `_global.scss`, and `_content.scss` respectively), referenced via `@apply row`, `@apply white-links`, `@apply content` as a shorthand for composing them. Once those three files are converted to plain CSS (their own tasks below), replace any `@apply row` / `@apply white-links` / `@apply content` elsewhere with `@extend .row;` / `@extend .white-links;` / `@extend .content;` (SCSS `@extend`, not Tailwind `@apply`).

---

## Phase A: Foundation

### Task 1: Create the design-tokens settings file

**Files:**
- Create: `resources/scss/settings/_variables.scss`

- [ ] **Step 1: Write the file**

```scss
@use 'sass:map';
@use 'sass:meta';

// Colors
$colors: (
    'transparent': transparent,
    'current': currentColor,
    'black': #09090b,
    'white': #ffffff,
    'gray': (
        50: #fafafa,
        100: #f4f4f5,
        200: #e4e4e7,
        300: #d4d4d8,
        400: #a1a1aa,
        DEFAULT: #a1a1aa,
        500: #71717a,
        600: #52525b,
        700: #3f3f46,
        800: #27272a,
        900: #18181b,
    ),
    'green': (
        50: #cedddb,
        100: #9ebbb6,
        200: #6d9892,
        300: #3d766d,
        400: #0c5449,
        DEFAULT: #0c5449,
        500: #0b4a40,
        600: #094038,
        700: #08352f,
        800: #062b27,
        900: #05211e,
    ),
    'gold': (
        50: #fff5d6,
        100: #ffebad,
        200: #ffe085,
        300: #ffd65c,
        400: #ffcc33,
        DEFAULT: #ffcc33,
        500: #edbd2c,
        600: #dbae25,
        700: #c89f1f,
        800: #b69018,
        900: #a48111,
    ),
    'red': (
        50: #fef2f2,
        300: #fca5a5,
        600: #dc2626,
    ),
);

@function color($name, $shade: 'DEFAULT') {
    $group: map.get($colors, $name);

    @if meta.type-of($group) == 'map' {
        @return map.get($group, $shade);
    }

    @return $group;
}

// Convenience flat variables for the most-referenced colors
$color-green: color('green');
$color-gold: color('gold');
$color-gray: color('gray');
$color-black: color('black');
$color-white: color('white');

// Breakpoints (min-width, px)
$breakpoints: (
    'sm': 420px,
    'md': 576px,
    'lg': 732px,
    'xl': 869px,
    '2xl': 1044px,
    '3xl': 1200px,
    'mt': 780px,
);

// Spacing / gutter scale
$spacing-container: max(1rem, (100% - 73rem) / 2);
$spacing-gutter-xs: 0.5rem;
$spacing-gutter-sm: 1rem;
$spacing-gutter: 2rem;
$spacing-gutter-md: 3rem;
$spacing-gutter-lg: 4rem;
$spacing-gutter-xl: 5rem;

// Z-index scale (project-specific)
$z-1: 1;
$z-2: 2;
$z-3: 3;
$z-4: 4;

// Font families (from tailwind.config.js fontFamily)
$font-sans: Lato, system-ui, BlinkMacSystemFont, -apple-system, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
$font-serif: Georgia, Times, 'Times New Roman', serif;
$font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
```

- [ ] **Step 2: Commit**

```bash
git add resources/scss/settings/_variables.scss
git commit -m "feat: add SCSS design-token settings file replacing tailwind.config.js theme"
```

### Task 2: Create the reset (Preflight replacement)

The exact rules below were captured by running Tailwind's own CLI against this project's live config (`npx tailwindcss -i <empty-input-with-@tailwind-base> -o output.css --config tailwind.config.js`) and stripping the `--tw-*` custom-property scaffolding block, which exists only to support Tailwind's own utility-composition system (transforms, rings, filters) and has no visual effect on its own — none of it is needed since we're not keeping Tailwind's utility classes. What remains below is the actual Preflight reset.

**Files:**
- Create: `resources/scss/settings/_reset.scss`

- [ ] **Step 1: Write the file**

```scss
/*
Preflight reset, copied verbatim from Tailwind CSS v3.4.19's `@tailwind base`
output (captured against this project's tailwind.config.js) so visual output
is preserved exactly after Tailwind is removed.
*/

*,
::before,
::after {
    box-sizing: border-box;
    border-width: 0;
    border-style: solid;
    border-color: #e4e4e7;
}

::before,
::after {
    --tw-content: '';
}

html,
:host {
    line-height: 1.5;
    -webkit-text-size-adjust: 100%;
    -moz-tab-size: 4;
    tab-size: 4;
    font-family: $font-sans;
    font-feature-settings: normal;
    font-variation-settings: normal;
    -webkit-tap-highlight-color: transparent;
}

body {
    margin: 0;
    line-height: inherit;
}

hr {
    height: 0;
    color: inherit;
    border-top-width: 1px;
}

abbr:where([title]) {
    text-decoration: underline dotted;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-size: inherit;
    font-weight: inherit;
}

a {
    color: inherit;
    text-decoration: inherit;
}

b,
strong {
    font-weight: bolder;
}

code,
kbd,
samp,
pre {
    font-family: $font-mono;
    font-feature-settings: normal;
    font-variation-settings: normal;
    font-size: 1em;
}

small {
    font-size: 80%;
}

sub,
sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline;
}

sub {
    bottom: -0.25em;
}

sup {
    top: -0.5em;
}

table {
    text-indent: 0;
    border-color: inherit;
    border-collapse: collapse;
}

button,
input,
optgroup,
select,
textarea {
    font-family: inherit;
    font-feature-settings: inherit;
    font-variation-settings: inherit;
    font-size: 100%;
    font-weight: inherit;
    line-height: inherit;
    letter-spacing: inherit;
    color: inherit;
    margin: 0;
    padding: 0;
}

button,
select {
    text-transform: none;
}

button,
input:where([type='button']),
input:where([type='reset']),
input:where([type='submit']) {
    appearance: button;
    background-color: transparent;
    background-image: none;
}

:-moz-focusring {
    outline: auto;
}

:-moz-ui-invalid {
    box-shadow: none;
}

progress {
    vertical-align: baseline;
}

::-webkit-inner-spin-button,
::-webkit-outer-spin-button {
    height: auto;
}

[type='search'] {
    appearance: textfield;
    outline-offset: -2px;
}

::-webkit-search-decoration {
    appearance: none;
}

::-webkit-file-upload-button {
    appearance: button;
    font: inherit;
}

summary {
    display: list-item;
}

blockquote,
dl,
dd,
h1,
h2,
h3,
h4,
h5,
h6,
hr,
figure,
p,
pre {
    margin: 0;
}

fieldset {
    margin: 0;
    padding: 0;
}

legend {
    padding: 0;
}

ol,
ul,
menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

dialog {
    padding: 0;
}

textarea {
    resize: vertical;
}

input::placeholder,
textarea::placeholder {
    opacity: 1;
    color: $color-gray;
}

button,
[role='button'] {
    cursor: pointer;
}

:disabled {
    cursor: default;
}

img,
svg,
video,
canvas,
audio,
iframe,
embed,
object {
    display: block;
    vertical-align: middle;
}

img,
video {
    max-width: 100%;
    height: auto;
}

[hidden]:where(:not([hidden='until-found'])) {
    display: none;
}
```

This file is imported *after* `_variables.scss` (so `$font-sans`, `$font-mono`, `$color-gray` resolve) — see Task 5.

- [ ] **Step 2: Commit**

```bash
git add resources/scss/settings/_reset.scss
git commit -m "feat: add hand-owned Preflight-equivalent reset, captured from current Tailwind build"
```

### Task 3: Create the responsive mixin

**Files:**
- Create: `resources/scss/settings/_mixins.scss`

- [ ] **Step 1: Write the file**

```scss
@use 'sass:map';

@mixin respond-to($breakpoint) {
    @if not map.has-key($breakpoints, $breakpoint) {
        @error "Unknown breakpoint `#{$breakpoint}`. Available: #{map.keys($breakpoints)}";
    }

    @media (min-width: map.get($breakpoints, $breakpoint)) {
        @content;
    }
}
```

- [ ] **Step 2: Commit**

```bash
git add resources/scss/settings/_mixins.scss
git commit -m "feat: add respond-to mixin replacing Tailwind's @screen"
```

### Task 4: Wire the settings layer into main.scss

**Files:**
- Modify: `resources/scss/main.scss:1-10`

- [ ] **Step 1: Add the settings imports directly after the existing `@tailwind` directives (do not remove those yet — Tailwind stays active until Phase F so the build keeps compiling while components are converted one at a time)**

```scss
/* Combination of normalize and tailwind resets */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Settings: design tokens, mixins, and the hand-owned reset (used by files as they're migrated off @apply) */
@import "settings/variables";
@import "settings/mixins";
@import "settings/reset";

@import "~mediabox/dist/mediabox";
```

- [ ] **Step 2: Build and confirm no regressions**

Run: `make build`
Expected: build succeeds with no Sass/PostCSS errors. Two resets are now stacked (Tailwind's Preflight via `@tailwind base`, plus the hand-copied one) — this is intentionally redundant and harmless (identical rules), and gets resolved in Phase F when `@tailwind base` is removed.

- [ ] **Step 3: Commit**

```bash
git add resources/scss/main.scss
git commit -m "feat: wire new settings/ layer into main.scss"
```

---

## Phase B: Component SCSS conversion (`@apply`/`@screen` removal)

**Standard Component Conversion Procedure** (referenced by name in every task in this phase):
1. Open the file.
2. For every `@apply ...;` call, resolve each utility token using Appendix A and replace the call with the equivalent plain CSS declarations (one per line, grouped logically).
3. For every `@screen <bp> { ... }` block, replace with `@include respond-to(<bp>) { ... }`.
4. For hover/focus/print/group-hover variants embedded in an `@apply` line, apply the A.7 wrapping rules.
5. Leave everything else in the file (selectors, plain CSS already present, comments) unchanged.
6. Run `make stylelint` — fix any formatting issues it flags.
7. Run `make build` and visually compare the affected page/component in the browser against the same page on `master` (use the `/styleguide` route to find the relevant demo page — see `styleguide/menu.json` for the catalog).
8. Commit with message `refactor: convert <file> from @apply to plain CSS`.

### Task 5 (worked example): Convert `_skip.scss`

**Files:**
- Modify: `resources/scss/components/_skip.scss`

- [ ] **Step 1: Replace the file contents**

Current content:
```scss
.skip a {
    @apply absolute h-px w-px text-left overflow-hidden text-black bg-white p-2;

    left: -1000px;
}

.skip a:active,
.skip a:focus,
.skip a:hover {
    @apply left-0 top-0 overflow-visible z-50 w-auto h-auto;
}
```

New content:
```scss
.skip a {
    position: absolute;
    height: 1px;
    width: 1px;
    text-align: left;
    overflow: hidden;
    color: $color-black;
    background-color: $color-white;
    padding: 0.5rem;
    left: -1000px;
}

.skip a:active,
.skip a:focus,
.skip a:hover {
    left: 0;
    top: 0;
    overflow: visible;
    z-index: 50;
    width: auto;
    height: auto;
}
```

- [ ] **Step 2: Run stylelint**

Run: `make stylelint`
Expected: passes with no errors for this file.

- [ ] **Step 3: Build and visually verify**

Run: `make build`, then load any page and Tab to the skip link (or use browser devtools to force `:focus` on `.skip a`) — confirm it's visually identical to `master`.

- [ ] **Step 4: Commit**

```bash
git add resources/scss/components/_skip.scss
git commit -m "refactor: convert _skip.scss from @apply to plain CSS"
```

### Task 6 (worked example): Convert `_bg-gradient.scss`

This file demonstrates three extra cases: a pseudo-element (`::before`), a `theme()` PostCSS function call, and a `print:` variant.

**Files:**
- Modify: `resources/scss/components/_bg-gradient.scss`

- [ ] **Step 1: Replace the file contents**

Current content:
```scss
@layer utilities {
    /* Gradient overlay */
    .bg-gradient-darkest::before {
        @apply absolute inset-0;

        content: '';
        background-image: radial-gradient(300% 100% at 50% 100%, rgba(#05211e, 0.93) 0%, transparent 100%);

        @media print {
            @apply bg-none;
        }
    }

    /* Backgrounds */
    .bg-gradient-green {
        @apply bg-green-600;

        background-image: linear-gradient(180deg, theme('colors.green.DEFAULT') 0, theme('colors.green.600'));

        &:hover {
            @apply bg-green-600;

            background-image: none;
        }
    }
}
```

New content (`theme('colors.green.DEFAULT')` → `$color-green`, `theme('colors.green.600')` → `color('green', 600)`; the outer `@layer utilities { }` wrapper is dropped since it was only meaningful within Tailwind's cascade-layer scheme):

```scss
/* Gradient overlay */
.bg-gradient-darkest::before {
    position: absolute;
    inset: 0;
    content: '';
    background-image: radial-gradient(300% 100% at 50% 100%, rgba(#05211e, 0.93) 0%, transparent 100%);

    @media print {
        background-image: none;
    }
}

/* Backgrounds */
.bg-gradient-green {
    background-color: $color-green;
    background-image: linear-gradient(180deg, $color-green 0, color('green', 600));

    &:hover {
        background-color: color('green', 600);
        background-image: none;
    }
}
```

- [ ] **Step 2: Run stylelint**

Run: `make stylelint`
Expected: passes with no errors for this file.

- [ ] **Step 3: Build and visually verify**

Run: `make build`, check any page using a full-width dark hero/CTA background (see `styleguide/menu.json` for hero/CTA demo pages) against `master`.

- [ ] **Step 4: Commit**

```bash
git add resources/scss/components/_bg-gradient.scss
git commit -m "refactor: convert _bg-gradient.scss from @apply to plain CSS"
```

### Task 7: Convert remaining component/partial SCSS files

Apply the **Standard Component Conversion Procedure** (defined at the top of Phase B) to each file below, in order. Each is its own commit. Two files have specific notes; the rest are purely mechanical.

- [ ] `resources/scss/components/_accordion.scss`
- [ ] `resources/scss/components/_carousel.scss`
- [ ] `resources/scss/components/_catalog.scss`
- [ ] `resources/scss/components/_cms-layouts.scss`
- [ ] `resources/scss/components/_content.scss` — **note:** this file defines the project's own `.content` class. Once converted, this is the target of the `@extend .content;` substitution described in Appendix A.8; don't rename the class.
- [ ] `resources/scss/components/_external-icon.scss`
- [ ] `resources/scss/components/_flag.scss` — contains `@apply row relative;` twice; per A.8, after `_row.scss` (below) is converted, change these to `@extend .row;\n    position: relative;`
- [ ] `resources/scss/components/_formy.scss`
- [ ] `resources/scss/components/_full-width-styleguide-hero.scss`
- [ ] `resources/scss/components/_global-buttons.scss` — contains three `@apply text-{size} !important;` lines (A.7 `!important` rule)
- [ ] `resources/scss/components/_global-headings.scss`
- [ ] `resources/scss/components/_global-tables.scss`
- [ ] `resources/scss/components/_global.scss` — defines the project's own `.white-links` class (A.8 target); also contains the body/link/hr/placeholder rules already discussed in the spec
- [ ] `resources/scss/components/_hero.scss` — largest file (338 lines); contains `@apply row w-full px-4 pt-10 pb-6 text-center content text-white white-links relative;` — this single line uses **both** custom classes from A.8 (`content`, `white-links`) plus `row`; after `_row.scss`, `_content.scss`, and `_global.scss` are converted, translate this to three `@extend` statements plus the remaining plain-utility declarations
- [ ] `resources/scss/components/_menu-icon.scss`
- [ ] `resources/scss/components/_menu-main.scss`
- [ ] `resources/scss/components/_menu-slideout.scss`
- [ ] `resources/scss/components/_pdf.scss`
- [ ] `resources/scss/components/_play-video-button.scss`
- [ ] `resources/scss/components/_print.scss`
- [ ] `resources/scss/components/_responsive-embed.scss`
- [ ] `resources/scss/components/_row.scss` — convert first among the A.8 files (small, 3 lines) since `_flag.scss` and `_hero.scss` above depend on it being done
- [ ] `resources/scss/components/_slate.scss`
- [ ] `resources/scss/components/_tabs.scss`
- [ ] `resources/scss/partials/_layout.scss`
- [ ] `resources/scss/partials/_nav-top.scss`

`resources/scss/site-specific/_theme.scss` contains no `@apply`/`@screen` (only a commented-out example) — no action needed, skip it.

`resources/scss/partials/_component-loop.scss` is handled separately in Phase D, since its conversion is combined with expanding the dynamic safelist classes.

**Ordering constraint:** convert `_row.scss` before `_flag.scss` and `_hero.scss` (both `@extend .row`); convert `_content.scss` and `_global.scss` before `_hero.scss` (which extends `.content` and `.white-links`).

- [ ] After all files above are converted, run the full check: `make phplint && make stylelint && make runtests`
Expected: all pass.

---

## Phase C: Blade template conversion (utility classes → semantic classes)

**Standard Blade Conversion Procedure** (referenced by name in every task in this phase):
1. Open the Blade file.
2. For each element carrying Tailwind utility classes, decide on one semantic class name (BEM-ish, scoped to the component — e.g. `promo-header`, `promo-header__title`).
3. If a matching SCSS file already exists under `resources/scss/components/` for this component, add the new class's rules there. Otherwise, create a new file `resources/scss/components/_<name>.scss` and add `@import "components/<name>";` to `resources/scss/main.scss` (alphabetically among the existing component imports).
4. Resolve every utility class on the element via Appendix A and write the equivalent plain CSS under the new semantic class (wrapping responsive/state variants per A.7).
5. Replace the utility classes on the Blade element with the new semantic class, preserving any non-utility classes already present (IDs, JS hooks, conditionally-added classes via `@if`/`@class`).
6. Run `make stylelint`.
7. Run `make build` and visually compare the page against `master` (use `/styleguide` to find a demo of this component if the template itself isn't directly browsable).
8. Commit: `refactor: replace Tailwind utilities with semantic classes in <file>`.

### Task 8 (worked example): Convert `components/breadcrumbs.blade.php`

**Files:**
- Modify: `resources/views/components/breadcrumbs.blade.php`
- Create: `resources/scss/components/_breadcrumbs.scss`
- Modify: `resources/scss/main.scss` (add import)

- [ ] **Step 1: Add the new component SCSS file**

```scss
.breadcrumbs {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    max-width: 1200px;
    padding-left: 1rem;
    padding-right: 1rem;
    margin-left: auto;
    margin-right: auto;

    @media print {
        margin-top: 0;
    }

    ul {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    &--flagged ul {
        @include respond-to(mt) {
            width: 80%;
        }
    }
}

.breadcrumbs__home-icon {
    color: $color-black;
    vertical-align: middle;
}

.breadcrumbs__separator {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.breadcrumbs__current {
    font-weight: 700;
    color: $color-green;
    display: inline;
}

.breadcrumbs__link {
    color: $color-green;

    &:hover {
        text-decoration-line: underline;
    }
}
```

- [ ] **Step 2: Add the import to main.scss**

In `resources/scss/main.scss`, add `@import "components/breadcrumbs";` alongside the other `@import "components/..."` lines (alphabetically, after `bg-gradient` and before `carousel`).

- [ ] **Step 3: Update the Blade template**

```blade
{{--
    $breadcrumbs => array // ['display_name', 'relative_url']
--}}
@if (!empty($breadcrumbs))
<nav id="breadcrumbs-menu" class="breadcrumbs @if(!empty($base['flag']))breadcrumbs--flagged @endif" aria-label="Breadcrumbs">
    <ul>
        @foreach($breadcrumbs as $key=>$crumb)
            @if($key == 0)
                <li class="inline">
                    <a href="/" aria-labelledby="home"><span class="breadcrumbs__home-icon">@svg('home', 'w-4 h-4 inline align-baseline')</span></a>
                    <span class="icon-right-open breadcrumbs__separator"></span>
            @elseif($key == (count($breadcrumbs) - 1))
                <li class="breadcrumbs__current">
                    {{ $crumb['display_name'] }}
            @else
                <li class="inline">
                <a href="{{ $crumb['relative_url'] }}" class="breadcrumbs__link">{{ $crumb['display_name'] }}</a>
                <span class="icon-right-open breadcrumbs__separator"></span>
            @endif
            </li>
        @endforeach
    </ul>
</nav>
@endif
```

Note: `class="inline"` on the `<li>` elements and the `@svg(...)` helper's own `w-4 h-4 inline align-baseline` classes are left as-is here — `inline` is a one-word display utility used all over the templates; it's addressed once, globally, in Task 11 (Phase E) rather than per-template, since (like `.hidden`/`.flex`) it's simpler as a single shared plain class than as N duplicated semantic rules. Same applies to any other bare single-property utility (`block`, `relative`, `absolute`, `text-center`, etc.) encountered in later template tasks — see Task 11 for the exact shared-utility list before deciding case by case.

- [ ] **Step 4: Run stylelint, build, and visually verify**

Run: `make stylelint && make build`
Then load any content page with breadcrumbs enabled and compare against `master`.

- [ ] **Step 5: Commit**

```bash
git add resources/views/components/breadcrumbs.blade.php resources/scss/components/_breadcrumbs.scss resources/scss/main.scss
git commit -m "refactor: replace Tailwind utilities with semantic classes in breadcrumbs"
```

### Task 9: Convert remaining Blade templates

First, regenerate the authoritative file list. **Do not use a narrow utility-prefix denylist grep for this** — one was used during planning and undercounted the work: it misses the bulk of the utility surface actually present (`font-bold` ~65×, `gap-` ~60×, `relative` ~69×, `text-green`/`text-white`, `opacity-`, `space-y-` ~34×, `order-` ~25×, `leading-`, `object-`, `z-N`, `italic`, `uppercase`, `text-2xl`, `rounded-full`, `absolute`, …), so a template styled only with e.g. `text-2xl text-white uppercase` is silently not flagged. Use a **broad** utility grep for discovery — it is acceptable for the file-list to over-match here (semantic classes like `promo-header` won't match these prefixes; the per-file conversion pass is what confirms each file), but it must not under-match:

Run: `grep -rlE 'class="[^"]*\b(flex|grid|inline|block|hidden|table|contents|flow-root|(p|m|w|h|min-h|max-h|max-w|top|bottom|left|right|inset|gap|space|order|col|row|z|opacity|leading|tracking|border|rounded|shadow|outline|ring|fill|object|aspect|basis|grow|shrink|translate|scale|rotate|duration|delay|ease|transition)-|(text|bg|from|via|to|border|outline|ring|fill|divide|placeholder)-(\[|[a-z]|-?[0-9])|(items|justify|self|content|place|align|whitespace|break)-|font-(black|bold|semibold|medium|light|normal|mono|serif|sans)|(uppercase|lowercase|capitalize|italic|underline|truncate|relative|absolute|fixed|sticky|static)\b|(sm|md|lg|xl|2xl|3xl|mt|print|hover|focus|group|group-hover):)' resources/views styleguide/Views --include="*.blade.php"`

Cross-check the result against the static list below (captured at planning time); investigate any file that appears in one but not the other. Apply the **Standard Blade Conversion Procedure** (top of Phase C) to each file found, in the order listed:

- [ ] `resources/views/article.blade.php`
- [ ] `resources/views/articles.blade.php`
- [ ] `resources/views/components/accordion-styleguide.blade.php`
- [ ] `resources/views/components/accordion.blade.php`
- [ ] `resources/views/components/button-column.blade.php`
- [ ] `resources/views/components/button-row.blade.php`
- [ ] `resources/views/components/buttons/image.blade.php`
- [ ] `resources/views/components/catalog-flex.blade.php`
- [ ] `resources/views/components/catalog.blade.php`
- [ ] `resources/views/components/events-column.blade.php`
- [ ] `resources/views/components/events-featured-column.blade.php`
- [ ] `resources/views/components/events-featured-row.blade.php`
- [ ] `resources/views/components/events-row.blade.php`
- [ ] `resources/views/components/footer-contact.blade.php`
- [ ] `resources/views/components/footer-social.blade.php`
- [ ] `resources/views/components/hero-video.blade.php`
- [ ] `resources/views/components/icons-column.blade.php`
- [ ] `resources/views/components/icons-row.blade.php`
- [ ] `resources/views/components/icons-top-row.blade.php`
- [ ] `resources/views/components/image-lazy.blade.php`
- [ ] `resources/views/components/news-and-events-row.blade.php`
- [ ] `resources/views/components/news-column.blade.php`
- [ ] `resources/views/components/news-featured-column.blade.php`
- [ ] `resources/views/components/news-row.blade.php`
- [ ] `resources/views/components/profile.blade.php`
- [ ] `resources/views/components/promo/grid-item.blade.php`
- [ ] `resources/views/components/promo/list-item.blade.php`
- [ ] `resources/views/components/skip.blade.php`
- [ ] `resources/views/components/spotlight-column.blade.php`
- [ ] `resources/views/components/spotlight-row.blade.php`
- [ ] `resources/views/components/tabs.blade.php`
- [ ] `resources/views/contact-tables.blade.php`
- [ ] `resources/views/directory.blade.php`
- [ ] `resources/views/homepage.blade.php`
- [ ] `resources/views/layouts/main.blade.php`
- [ ] `resources/views/partials/component-loop.blade.php`
- [ ] `resources/views/partials/nav-left.blade.php`
- [ ] `resources/views/partials/nav-top.blade.php`
- [ ] `resources/views/profile-listing.blade.php`
- [ ] `resources/views/profile-view.blade.php`
- [ ] `resources/views/promo-view.blade.php`
- [ ] `resources/views/topics.blade.php`
- [ ] `styleguide/Views/styleguide-cms-basic-layouts.blade.php`
- [ ] `styleguide/Views/styleguide-cms-buttons.blade.php`
- [ ] `styleguide/Views/styleguide-cms-colors.blade.php`
- [ ] `styleguide/Views/styleguide-cms-figure.blade.php`
- [ ] `styleguide/Views/styleguide-cms-forms.blade.php`
- [ ] `styleguide/Views/styleguide-cms-heading-styles.blade.php`
- [ ] `styleguide/Views/styleguide-cms-tables.blade.php`
- [ ] `styleguide/Views/styleguide-cms-video.blade.php`
- [ ] `styleguide/Views/styleguide-component-buttons.blade.php`
- [ ] `styleguide/Views/styleguide-component-guide.blade.php`
- [ ] `styleguide/Views/styleguide-component-promo-column.blade.php`
- [ ] `styleguide/Views/styleguide-footer-contact.blade.php`
- [ ] `styleguide/Views/styleguide.blade.php`

- [ ] After all files above are converted, run: `make phplint && make stylelint && make runtests`
Expected: all pass.

---

## Phase D: Dynamic/parametric layout classes

### Task 10: Hand-author the dynamic/parametric layout classes

CMS-driven layouts render class names built from runtime column counts (currently satisfied by Tailwind's `safelist` in `tailwind.config.js`: `grid-cols-*`, `w-N/N` per breakpoint, `columns-*`, `colspan-*` per `mt`, `left-span-*`/`right-span-*` per `mt`, `order-*` per breakpoint, `px-container` per breakpoint, `gutter-*` per breakpoint). `_component-loop.scss` already hand-defines `.colspan-1`–`.colspan-12` outside Tailwind's generator (lines 8–65) — this task converts that file's remaining `@apply` calls and extends the same hand-authored pattern to cover the other safelisted patterns.

**Files:**
- Modify: `resources/scss/partials/_component-loop.scss`

- [ ] **Step 1: Grep every dynamic class actually referenced from Blade/PHP so nothing in the safelist is ported speculatively**

Run: `grep -rnE "grid-cols-|w-[0-9]/[0-9]|columns(-[0-9])?|left-span-|right-span-|order-[0-9]|px-container|gutter-[a-z]*" resources/views styleguide app --include="*.blade.php" --include="*.php"`

Use the output to confirm the exact set of dynamic classes still needed (some safelist patterns may be leftover/unused — the build already warned `colspan-([1-12])?` doesn't match any real class during Task 2's capture, confirming at least one safelist entry is stale).

- [ ] **Step 2: Convert existing `@apply`/`@screen` calls in this file per the Standard Component Conversion Procedure (Phase B), and add hand-authored classes for every dynamic pattern confirmed as still in use in Step 1**, following the existing `.colspan-N` style (plain CSS class per value, using `$breakpoints`/`respond-to()` for the responsive variants the old safelist declared). Example pattern for `order-N`:

```scss
.order-1 { order: 1; }
.order-2 { order: 2; }
// ... through the highest N actually used, per Step 1's grep output

@include respond-to(md) {
    .md\:order-1 { order: 1; }
    // ...
}
```

(Escaping the `:` in class selectors like `.md\:order-1` matches the literal class name Blade renders today, e.g. `class="md:order-1"` — keep the exact current class-naming convention so no Blade markup needs to change for these dynamic classes.)

- [ ] **Step 2a: Exempt the escaped-colon selectors from `selector-class-pattern`**

The escaped responsive classes (`.md\:order-1`, `.2xl\:order-3`, etc.) violate `.stylelintrc`'s `selector-class-pattern` regex — verified: `make stylelint` reports `Expected ".md\:order-1" to match pattern …`. Because **all** of these dynamic escaped-colon classes live in this one file, wrap them in a file-scoped disable rather than weakening the global pattern (a global regex change is fragile — matching a literal backslash in the class token is error-prone — and would loosen linting everywhere else):

```scss
/* stylelint-disable selector-class-pattern -- dynamic responsive classes (e.g. .md\:order-1) mirror the exact CMS-rendered class names and intentionally keep Tailwind's escaped-colon naming */
.md\:order-1 { order: 1; }
/* ... all escaped-colon responsive dynamic classes ... */
/* stylelint-enable selector-class-pattern */
```

Non-escaped dynamic classes (`.colspan-N`, `.order-1`) satisfy the pattern and stay outside the disabled block. Verified: this scoped disable passes `make stylelint` cleanly against the current `.stylelintrc`.

- [ ] **Step 3: Run stylelint, build, and visually verify**

Run: `make stylelint && make build`
Expected: stylelint passes (the escaped-colon classes are covered by the Step 2a disable block; without it, it fails on `selector-class-pattern`).
Then check every layout permutation on `/styleguide` under the layout/grid demo pages (see `styleguide/menu.json`) against `master`.

- [ ] **Step 4: Commit**

```bash
git add resources/scss/partials/_component-loop.scss
git commit -m "refactor: hand-author dynamic layout classes, replacing Tailwind safelist"
```

---

## Phase E: JS-toggled state classes

### Task 11: Add shared JS-toggled and single-property utility classes

`.hidden` and `.flex` are toggled by class name directly in JS (`classList.add/remove/toggle`) — they must exist as plain global classes, not be renamed. `inline`, `block`, `relative`, `absolute`, `text-center`, and other single-property utilities encountered while converting Blade templates in Phase C but not tied to any specific component (e.g. used as one-off layout nudges rather than as part of a semantic component) are consolidated here too, rather than being redefined per-component.

**Files:**
- Modify: `resources/scss/components/_global.scss`

- [ ] **Step 1: Confirm the exact set of JS-toggled classes**

Run: `grep -rhoE "classList\.(add|remove|toggle)\('[a-z-]+'\)" resources/js/`
Expected output includes `hidden` and `flex` (from `slideout.js`, `slideout-main-menu.js`, `carousel.js`, `accordion.js`).

- [ ] **Step 2: Add the shared utility classes to `_global.scss`**

```scss
/* Shared utility classes: intentionally kept as plain, reusable classes rather than
   folded into semantic components — .hidden and .flex are toggled by class name
   directly from JS (slideout.js, slideout-main-menu.js, carousel.js, accordion.js). */
.hidden {
    display: none;
}

.flex {
    display: flex;
}

.block {
    display: block;
}

.inline {
    display: inline;
}

.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.text-center {
    text-align: center;
}
```

- [ ] **Step 3: Run stylelint, build, and verify JS-driven interactions**

Run: `make stylelint && make build`
Then manually exercise the mobile slideout menu, a carousel, and an accordion in the browser (each toggles `.hidden`/`.flex`) and confirm they still show/hide correctly.

- [ ] **Step 4: Commit**

```bash
git add resources/scss/components/_global.scss
git commit -m "feat: add shared JS-toggled and single-property utility classes"
```

---

## Phase F: Remove Tailwind

Only start this phase once Phases B–E are complete and `grep -r "@apply\|@screen" resources/scss` returns no results, and the Blade grep from Task 9's Step 1 returns no files.

### Task 12: Verify nothing still depends on Tailwind

**Files:** none (verification only)

- [ ] **Step 1: Confirm no `@apply`/`@screen` remain**

Run: `grep -rn "@apply\|@screen" resources/scss`
Expected: no output.

- [ ] **Step 2: Confirm no Blade file still uses Tailwind utility classes**

This is the completeness gate, so it must **not** use the narrow planning-era denylist (which misses most utilities — see Task 9 Step 1). Use the same broad utility regex as Task 9's discovery step:

Run: `grep -rlE 'class="[^"]*\b(flex|grid|inline|block|hidden|table|contents|flow-root|(p|m|w|h|min-h|max-h|max-w|top|bottom|left|right|inset|gap|space|order|col|row|z|opacity|leading|tracking|border|rounded|shadow|outline|ring|fill|object|aspect|basis|grow|shrink|translate|scale|rotate|duration|delay|ease|transition)-|(text|bg|from|via|to|border|outline|ring|fill|divide|placeholder)-(\[|[a-z]|-?[0-9])|(items|justify|self|content|place|align|whitespace|break)-|font-(black|bold|semibold|medium|light|normal|mono|serif|sans)|(uppercase|lowercase|capitalize|italic|underline|truncate|relative|absolute|fixed|sticky|static)\b|(sm|md|lg|xl|2xl|3xl|mt|print|hover|focus|group|group-hover):)' resources/views styleguide/Views --include="*.blade.php"`

Expected: no output. **This broad regex will also match the intentionally-retained global/single-property utility classes from Task 11 (`hidden`, `flex`, `block`, `inline`, `relative`, `absolute`, `text-center`).** Those are kept by design — if the only matches are files using exactly those retained classes (confirm by opening each hit), the gate is satisfied; any other utility token is a real leftover. For a stricter pass, follow up with an allowlist check: extract every distinct token from `class="..."` attributes and diff against the known-good vocabulary (semantic component classes, the Task 11 retained globals, and the Phase D dynamic/parametric classes) — anything outside that set is an un-migrated utility.

- [ ] **Step 3: Confirm no bare `@tailwindcss/forms`/`@tailwindcss/typography` plugin classes are referenced**

Run: `grep -rlE 'class="[^"]*\bprose\b|\bform-input\b|\bform-select\b|\bform-checkbox\b|\bform-radio\b|\bform-textarea\b' resources/views styleguide/Views --include="*.blade.php"`
Expected: no output. (This confirms the finding from the design spec — if this unexpectedly returns files, stop and handle those templates before continuing.)

### Task 13: Remove Tailwind from the build

> **Assumes the Vite migration has landed** (see Prerequisite at the top). The build is Vite-based; PostCSS plugins live in `postcss.config.js`; there is no `webpack.mix.js`. If `webpack.mix.js` still exists when you reach this task, the Vite migration hasn't happened — stop and do it first.

**Files:**
- Modify: `resources/scss/main.scss:1-6`
- Modify: `postcss.config.js`
- Modify: `vite.config.js` (only if it watches `tailwind.config.js`)
- Modify: `package.json`
- Delete: `tailwind.config.js`

- [ ] **Step 1: Remove the `@tailwind` directives from main.scss**

```scss
/* Settings: design tokens, mixins, and the hand-owned reset */
@import "settings/variables";
@import "settings/mixins";
@import "settings/reset";

@import "~mediabox/dist/mediabox";
```
(Delete the three `@tailwind base/components/utilities;` lines and their preceding comment that were at the top of the file.)

- [ ] **Step 2: Remove Tailwind from the PostCSS pipeline in `postcss.config.js`**

Remove the `tailwindcss` plugin entry from `postcss.config.js`, keeping `autoprefixer`. For example:
```js
// Before
export default { plugins: [require('tailwindcss'), require('autoprefixer')] };
// After
export default { plugins: [require('autoprefixer')] };
```
(Match the exact export/plugin syntax established by the Vite migration — CommonJS vs ESM, array vs object form.)

- [ ] **Step 3: Remove any `tailwind.config.js` watch entry from `vite.config.js`**

If the Vite migration added `tailwind.config.js` to a dev-server `server.watch`/reload list, remove it. If no such entry exists, skip this step.

- [ ] **Step 4: Delete `tailwind.config.js`**

```bash
rm tailwind.config.js
```

- [ ] **Step 5: Remove Tailwind packages from package.json**

Remove these three lines from `devDependencies`:
```json
    "@tailwindcss/forms": "^0.5.11",
    "@tailwindcss/typography": "^0.5.19",
```
```json
    "tailwindcss": "^3.4.19",
```

- [ ] **Step 6: Reinstall dependencies**

Run: `yarn install`
Expected: lockfile updates, no errors.

- [ ] **Step 7: Build and run the full check**

Run: `make build && make phplint && make stylelint && make runtests`
Expected: all pass.

- [ ] **Step 8: Commit**

```bash
git add resources/scss/main.scss postcss.config.js vite.config.js package.json yarn.lock
git rm tailwind.config.js
git commit -m "chore: remove tailwindcss and its plugins from the build"
```
(Only `git add` `vite.config.js` if Step 3 actually changed it.)

### Task 14: Clean up Stylelint config

**Files:**
- Modify: `.stylelintrc`

- [ ] **Step 1: Remove Tailwind-specific allowances**

Find:
```json
        "function-no-unknown": [ true, {
            "ignoreFunctions": [
                "theme"
            ]
        }],
```

Replace with:
```json
        "function-no-unknown": true,
```

Find:
```json
        "scss/at-rule-no-unknown": [ true, {
            "ignoreAtRules": [
                "include",
                "extend",
                "screen",
                "layer",
                "tailwind"
            ]
        }]
```

Replace with:
```json
        "scss/at-rule-no-unknown": [ true, {
            "ignoreAtRules": [
                "include",
                "extend"
            ]
        }]
```

(`layer` is dropped here on the assumption that Phase B's conversions dropped all `@layer` wrappers, per the "default: drop" guidance in the design spec. If any `@layer` blocks were deliberately kept during Phase B, add `"layer"` back to this list.)

- [ ] **Step 2: Run stylelint**

Run: `make stylelint`
Expected: passes with no errors across the whole codebase.

- [ ] **Step 3: Commit**

```bash
git add .stylelintrc
git commit -m "chore: remove Tailwind-specific stylelint allowances"
```

---

## Phase G: Final verification

### Task 15: Full CI-equivalent check and manual visual QA

**Files:** none (verification only)

- [ ] **Step 1: Run the full local CI sequence**

Run, in order (matching `.github/workflows/build.yml`):
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

- [ ] **Step 2: Confirm zero remaining Tailwind references anywhere in the app**

Run: `grep -rn "tailwind" --include="*.js" --include="*.php" --include="*.json" --include="*.scss" . --exclude-dir=node_modules --exclude-dir=vendor --exclude-dir=docs`
Expected: no output.

- [ ] **Step 3: Manual visual QA pass**

Open `/styleguide` and walk every page listed in `styleguide/menu.json` (every component and layout demo in the app), comparing each against the same page on `master`. Pay particular attention to: hero/CTA gradients (Task 6), form styling (`_formy.scss`, dropped `@tailwindcss/forms`), breadcrumbs (Task 8), the mobile slideout menu/carousel/accordion (Phase E, JS-toggled classes), and any CMS-configurable multi-column layout (Phase D, dynamic classes). Note and fix any visual diffs before proceeding — do not defer them.

- [ ] **Step 4: Final commit / summary**

No code changes expected at this step if everything above passed — this step exists to confirm sign-off. If diffs were found and fixed in Step 3, commit those fixes individually per the normal workflow (see Phase B/C task templates) before considering this task complete.