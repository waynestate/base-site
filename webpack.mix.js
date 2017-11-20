let webpack = require('webpack');
let mix = require('laravel-mix');
let fs = require('fs');
let path = require('path');
let exec = require('child_process').exec;
let package = JSON.parse(fs.readFileSync('./package.json'));
let CopyWebpackPlugin = require('copy-webpack-plugin');


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

// Copy the WSU HTTP Error templates, css, images
mix.copy([
    'vendor/waynestate/error-404/dist/404.css',
    'vendor/waynestate/error-404/dist/404.css.map',
    'vendor/waynestate/error-403/dist/403.css',
    'vendor/waynestate/error-403/dist/403.css.map',
    'vendor/waynestate/error-500/dist/500.css',
    'vendor/waynestate/error-500/dist/500.css.map'
], 'public/_resources/css');
mix.copy([
    'vendor/waynestate/error-404/dist/404.png',
    'vendor/waynestate/error-403/dist/403.png',
    'vendor/waynestate/error-500/dist/500.png'
], 'public/_resources/images');

// Copy the fonts
mix.copy([
    'resources/fonts/**/*',
    'node_modules/slick-carousel/slick/fonts/**/*'
], 'public/_resources/fonts');

// Copy the images
mix.copy([
    'resources/images/**/*.jpg',
    'resources/images/**/*.gif',
    'resources/images/**/*.png',
    'resources/images/**/*.svg',
    'node_modules/slick-carousel/slick/**/*.gif'
], 'public/_resources/images');

// Create the _static symlink
fs.symlink(
    path.resolve('./storage/app/public'),
    path.resolve('./public/_static'),
    function (err) { err.errno != -17 ? console.log(err) : console.log("Done."); }
);

// Compile JS and SCSS
mix.js('resources/js/main.js', 'public/_resources/js')
   .sass('resources/scss/main.scss', 'public/_resources/css')
   .browserSync({
        proxy: 'https://' + package.name + '.wayne.local',
        open: false,
        files: [
            'app/**/*.php',
            'resources/views/**/*.php',
            'public/_resources/js/**/*.js',
            'public/_resources/css/**/*.css'
        ]
    })
    .options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}

// Override webpack configuration
mix.webpackConfig({
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
                to: path.resolve('resources/views/partials/header.blade.php'),
            },
            {
                from: 'node_modules/@waynestate/wsufooter/dist/footer.html',
                to: path.resolve('resources/views/partials/footer.blade.php'),
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
                from: 'vendor/waynestate/error-500/dist/500.php',
                to: path.resolve('resources/views/errors/500.blade.php'),
            },
            {
                from: 'hooks',
                to: path.resolve('.git/hooks'),
            }
        ]),
    ]
});
