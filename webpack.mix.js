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
if(mix.inProduction()) {
    mix.copy([
        'resources/fonts/**/*',
        'node_modules/slick-carousel/slick/fonts/**/*'
    ], 'public/_resources/build/fonts');
}else{
    mix.copy([
        'resources/fonts/**/*',
        'node_modules/slick-carousel/slick/fonts/**/*'
    ], 'public/_resources/fonts');
}

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
   .sass('resources/scss/main.scss', 'public/_resources/css');

// We
mix.options({
    processCssUrls: false
});

// Auto refresh web browser when changes take place
mix.browserSync({
    proxy: 'https://' + package.name + '.wayne.local'
});

if (mix.inProduction()) {
    mix.version(['public/_resources/css/main.css', 'public/_resources/js/main.js']);
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

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.ts(src, output); <-- Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.fastSass('src', output); <-- Alias for mix.standaloneSass().
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });