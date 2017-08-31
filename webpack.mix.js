let mix = require('laravel-mix');
let fs = require('fs');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

require("fs").symlink(
    path.resolve('./storage/app/public'),
    path.resolve('./public/_static'),
    function (err) { console.log(err || "Done."); }
);

mix.js('resources/assets/js/app.js', 'public/_resources/js')
   .sass('resources/assets/sass/app.scss', 'public/_resources/css');
