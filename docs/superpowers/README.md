# Frontend build & styling migration — specs & plans

This directory holds the design specs and implementation plans for the frontend build-tooling and styling overhaul. The work is split into **two sequential migrations**. Each has a design spec (the "what/why") and an implementation plan (the task-by-task "how").

## Sequencing

These land in order — **do not start the second until the first has merged.**

```
1. Laravel Mix → Vite   (build tooling; Tailwind left fully intact)
        │
        ▼
2. Tailwind → plain Dart Sass   (CSS authoring; assumes Vite is already in place)
```

The Vite migration is first because doing so lets the Tailwind removal delete a single PostCSS plugin from `postcss.config.js` instead of editing a `webpack.mix.js` that would no longer exist.

## 1. Laravel Mix → Vite

Replace Laravel Mix (webpack) with Vite + `laravel-vite-plugin`. Preserves the custom `public/_resources/` output path, all ancillary build steps, and current compiled output. **No CSS/JS authoring changes; Tailwind stays.** Dev workflow is a polling `vite build --watch` (no HMR / no Vite dev server).

- Spec: [`specs/2026-07-22-laravel-mix-to-vite-design.md`](specs/2026-07-22-laravel-mix-to-vite-design.md)
- Plan: [`plans/2026-07-22-laravel-mix-to-vite-plan.md`](plans/2026-07-22-laravel-mix-to-vite-plan.md)

## 2. Remove Tailwind CSS → plain Dart Sass

Remove Tailwind v3 (and its plugins/build step) and replace every utility-class usage with hand-authored, semantic SCSS, with zero visual regressions. **Prerequisite: the Vite migration above must have landed** — by the time this runs, the build is Vite-based and Tailwind runs through `postcss.config.js`.

- Spec: [`specs/2026-07-22-tailwind-to-sass-design.md`](specs/2026-07-22-tailwind-to-sass-design.md)
- Plan: [`plans/2026-07-22-tailwind-to-sass-plan.md`](plans/2026-07-22-tailwind-to-sass-plan.md)