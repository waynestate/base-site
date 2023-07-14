const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');
const package = JSON.parse(fs.readFileSync('./package.json'));
const ESLintPlugin = require('eslint-webpack-plugin');
const replace = require('replace-in-file');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

// Copy & Rename Blade Files and Replace date in Footer, necessary to do outside of mix.copy and webpack plugins due to
// file changes causing infinite loops during make watch.
fs.copyFileSync('node_modules/@waynestate/wsuheader/dist/header.html', 'resources/views/components/header.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('node_modules/@waynestate/wsufooter/dist/footer.html', 'resources/views/components/footer.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-404/dist/404.php', 'resources/views/errors/404.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-403/dist/403.php', 'resources/views/errors/403.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-429/dist/429.php', 'resources/views/errors/429.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-500/dist/500.php', 'resources/views/errors/500.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-500/dist/500.php', 'resources/views/errors/500.blade.php', fs.constants.COPYFILE_FICLONE);
if(!fs.existsSync('.git/hooks')) {
    fs.mkdir('.git/hooks', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('.git/hooks directory created.');
    });

    fs.copyFileSync('hooks/pre-commit', '.git/hooks/pre-commit', fs.constants.COPYFILE_FICLONE);
}
replace.sync({
    files: 'resources/views/components/footer.blade.php',
    from: /2\d{3}/g,
    to: "{{ date('Y') }}",
});


// Error Files
mix.copy([
    'vendor/waynestate/error-404/dist/404.css',
    'vendor/waynestate/error-404/dist/404.css.map',
    'vendor/waynestate/error-403/dist/403.css',
    'vendor/waynestate/error-403/dist/403.css.map',
    'vendor/waynestate/error-429/dist/429.css',
    'vendor/waynestate/error-429/dist/429.css.map',
    'vendor/waynestate/error-500/dist/500.css',
    'vendor/waynestate/error-500/dist/500.css.map'
], 'public/_resources/css')

    // Header files
    .copy([
        'vendor/waynestate/error-404/dist/404.png',
        'vendor/waynestate/error-403/dist/403.png',
        'vendor/waynestate/error-429/dist/429.png',
        'vendor/waynestate/error-500/dist/500.png'
    ], 'public/_resources/images')

    // Fonts
    .copy([
        'resources/fonts/**/*'
    ], 'public/_resources/fonts')

    // Images
    .copyDirectory([
        'resources/images'
    ], 'public/_resources/images');

// Compile assets and setup browersync
mix.js('resources/js/main.js', 'public/_resources/js')
    .sass('resources/scss/main.scss', 'public/_resources/css/main.css')
    .sourceMaps()
    .options({
        processCssUrls: false,
        postCss: [
            require('tailwindcss'),
            require('autoprefixer')
        ]
    })
    .browserSync({
        proxy: 'https://' + package.name + '.wayne.local',
        open: false,
        files: [
            'app/**/*.php',
            'resources/views/**/*.php',
            'public/_resources/js/main.js',
            'public/_resources/css/main.css',
            'tailwind.config.js'
        ],
        watchOptions: {
            usePolling: true,
            interval: 500
        }
    });

// Create the _static symlink
fs.symlink(
    path.resolve('./storage/app/public'),
    path.resolve('./public/_static'),
    function (err) { err != null && err.errno != -17 ? console.log(err) : console.log("./storage/app/public symlinked to ./public/_static/ created."); }
);

config = {
    plugins: [
        new ESLintPlugin({
            exclude: [
                'node_modules'
            ],
        }),
    ],
    devtool: 'source-map'
};

if (mix.inProduction()) {
    // Version the CSS for cache busting
    mix.version();
}

// Override webpack configuration
mix.webpackConfig(config);
