let webpack = require('webpack');
let mix = require('laravel-mix');
let fs = require('fs');
let path = require('path');
let exec = require('child_process').exec;
let package = JSON.parse(fs.readFileSync('./package.json'));
let CopyWebpackPlugin = require('copy-webpack-plugin');
let purge = require('laravel-mix-purgecss');
let ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');

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
    .copy([
        'resources/images/**/*.jpg',
        'resources/images/**/*.gif',
        'resources/images/**/*.png',
        'resources/images/**/*.svg'
    ], 'public/_resources/images');

// Compile assets and setup browersync
mix.js('resources/js/main.js', 'public/_resources/js')
   .sass('resources/scss/main.scss', 'public/_resources/css/main.css')
   .purgeCss({
        globs: [
            path.join(__dirname, "resources/views/**/*.blade.php"),
            path.join(__dirname, "styleguide/Views/**/*.blade.php"),
            path.join(__dirname, "factories/**/*.php"),
            path.join(__dirname, "resources/js/**/*.js"),
            path.join(__dirname, "node_modules/slideout/dist/slideout.js"),
            path.join(__dirname, "node_modules/flickity/dist/flickity.pkgd.js"),
            path.join(__dirname, "node_modules/mediabox/dist/mediabox.js")
        ],
        extensions: ['html', 'js', 'php', 'vue'],
        whitelistPatterns: [/at-/, /w-[1-5]\/[1-5]/, /(sm|md|lg|xl|xxl|xxxl|mt)\:w-[1-5]\/[1-5]/]
    })
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
    function (err) { err != null && err.errno != -17 ? console.log(err) : console.log("Done."); }
);

config = {
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /node_modules/,
            enforce: 'pre',
            use: [{
                loader: 'eslint-loader'
            }],
        }],
    },
    plugins: [
        new webpack.LoaderOptionsPlugin({
            options: {
                eslint: {
                    configFile: path.join(__dirname, '.eslintrc'),
                },
            },
        }),
        new CopyWebpackPlugin([
            {
                from: 'node_modules/@waynestate/wsuheader/dist/header.html',
                to: path.resolve('resources/views/components/header.blade.php'),
            },
            {
                from: 'node_modules/@waynestate/wsufooter/dist/footer.html',
                to: path.resolve('resources/views/components/footer.blade.php'),
            },
            {
                from: 'vendor/waynestate/error-404/dist/404.php',
                to: path.resolve('resources/views/errors/404.blade.php'),
            },
            {
                from: 'vendor/waynestate/error-403/dist/403.php',
                to: path.resolve('resources/views/errors/403.blade.php'),
            },
            {
                from: 'vendor/waynestate/error-429/dist/429.php',
                to: path.resolve('resources/views/errors/429.blade.php'),
            },
            {
                from: 'vendor/waynestate/error-500/dist/500.php',
                to: path.resolve('resources/views/errors/500.blade.php'),
            },
            {
                from: 'hooks',
                to: path.resolve('.git/hooks'),
            }
        ]),
        new ReplaceInFileWebpackPlugin([{
            dir: 'resources/views/components',
            files: ['footer.blade.php'],
            rules: [{
                search: /2\d{3}/,
                replace: "{{ date('Y') }}"
            }]
        }])
    ],
    devtool: 'source-map'
};

if (mix.inProduction()) {
    // Version the CSS for cache busting
    mix.version();
}

// Override webpack configuration
mix.webpackConfig(config);
