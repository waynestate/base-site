import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Vite's ConfigEnv does NOT expose whether `--watch`/`-w` was passed on the
// CLI, and (verified empirically on vite@8.1.5) a plain `vite build` still
// runs in watch mode forever if `build.watch` is a non-null object in the
// resolved config -- it is NOT gated by the CLI flag as older Vite docs/plans
// assumed. Without this guard, `npm run production` / CI's `make build`
// would hang indefinitely. So `build.watch` is only populated when `--watch`
// (or `-w`) is actually present in argv.
const isWatchBuild = process.argv.includes('--watch') || process.argv.includes('-w');

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/main.scss', 'resources/js/main.js'],
            // Keep the current custom output path. Assets + manifest land in
            // public/_resources/ and @vite() resolves /_resources/...
            buildDirectory: '_resources',
            refresh: false, // no dev server / HMR
        }),
    ],
    resolve: {
        // resources/scss/main.scss has webpack-style `@import "~pkg/..."`
        // node_modules imports (sass-loader's `~` convention). Vite's Dart
        // Sass resolver has no built-in tilde support, so without this the
        // build fails with "Can't find stylesheet to import." Stripping the
        // leading `~` lets it fall through to normal bare-specifier /
        // node_modules resolution, which Vite handles natively.
        alias: [{ find: /^~/, replacement: '' }],
    },
    build: {
        // CRITICAL: public/_resources/ also holds COPIED assets (fonts, images,
        // error CSS). Do NOT let Vite empty it, or those copies get wiped.
        emptyOutDir: false,
        sourcemap: true, // match Mix's sourceMaps()
        // Polling watch build for Docker bind mounts, only for `--watch`
        // invocations (see isWatchBuild above). Vite 8 builds with Rolldown,
        // whose watcher takes `watcher.usePolling`/`pollInterval` (not
        // Rollup/chokidar's `chokidar: { usePolling, interval }`, which
        // Rolldown does not understand).
        watch: isWatchBuild
            ? {
                include: ['resources/**'],
                watcher: { usePolling: true, pollInterval: 500 },
            }
            : null,
    },
});
