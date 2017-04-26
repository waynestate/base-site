const elixir = require('laravel-elixir');
const sym = require('gulp-sym');
const replace = require('gulp-replace');
const rename = require('gulp-rename');
const del = require('del');
const fs = require('fs');
const scss = require('postcss-scss');
const gutil = require('gulp-util');
const exec = require('child_process').exec;
const package = JSON.parse(fs.readFileSync('./package.json'));

// Override default Elixir paths
elixir.config.publicPath = 'public/_resources';
elixir.config.assetsPath = 'resources';
elixir.config.css.sass.folder = 'scss';

// Override default Elixir configurations
elixir.config.css.autoprefix.options.browsers = ['> 1%', 'Last 4 versions'];
elixir.config.notifications = false;

// Get the environment variable Ex: "gulp --env=production"
var env = gutil.env.env;

elixir.extend('phplint', function() {
    new elixir.Task('phplint', function() {
        this.recordStep('Linting PHP');
        this.src = ['**/*.php'];
        this.output = '**/*.php';

        exec('make phplintdry', function (err, stdout, stderr) {
            if(err != null) {
                console.log(stdout);
                console.log(gutil.colors.bgRed('\nRun this to auto fix php lint errors: make phplint\n'));
            }
        });
    }).watch(['app/**/*.php', 'bootstrap/**/*.php', 'config/**/*.php', 'tests/**/*.php']);
});

// Make sure our SCSS meet our style standards
elixir.extend('stylelint', function() {
    new elixir.Task('stylelint', function() {
        // Sources
        var src_scss = elixir.config.assetsPath + '/' + elixir.config.css.sass.folder + '/**/*.scss';

        // Outputs
        var output_scss = src_scss;

        // Summary Reporting
        this.recordStep('Linting SCSS');
        this.src = src_scss;
        this.output = output_scss;

        exec('stylelint "' + src_scss + '" --syntax scss', function (err, stdout, stderr) {
            if(err != null) {
                console.log('Stylelint has errors:');
                console.log(stdout);
            }
        });
    }).watch(elixir.config.get('assets.css.sass.folder') + '/**/*');
});

// Copy fonts from source to destination
elixir.extend('copy_fonts', function() {
    new elixir.Task('copy_fonts', function() {
        // Sources
        var src_fonts = [
            'resources/fonts/**/*',
            'node_modules/slick-carousel/slick/fonts/**/*'
        ];

        // Outputs
        var output_fonts = (env == 'production') ? gulp.dest(elixir.config.publicPath + '/build/fonts') : elixir.config.publicPath + '/fonts';

        // Summary Reporting
        this.recordStep((env == 'production') ? 'Copying fonts to version' : 'Copying fonts');
        this.src = src_fonts;
        this.output = output_fonts;

        // Copy fonts for cache busting
        if(env == 'production') {
            return gulp.src(src_fonts)
                .pipe(output_fonts);
        }

        // Copy fonts
        return gulp.src(src_fonts)
            .pipe(gulp.dest(output_fonts))
   });
});

// Copy the images needed
elixir.extend('copy_images', function() {
    new elixir.Task('copy_images', function() {
        // Sources
        var src_images = [
            elixir.config.assetsPath + '/images/**/*.jpg',
            elixir.config.assetsPath + '/images/**/*.gif',
            elixir.config.assetsPath + '/images/**/*.png',
            elixir.config.assetsPath + '/images/**/*.svg',
            'node_modules/slick-carousel/slick/**/*.gif'
        ];

        // Outputs
        var output_images = elixir.config.publicPath + '/images';

        // Summary Reporting
        this.recordStep('Copying jpg');
        this.recordStep('Copying gif');
        this.recordStep('Copying png');
        this.recordStep('Copying slick carousel');
        this.src = src_images;
        this.output = output_images;

        return gulp.src(src_images)
        .pipe(gulp.dest(output_images));
    });
});

// Handle Header
elixir.extend('header', function() {
    new elixir.Task('header', function() {
        // Sources
        var src_html = [
            'node_modules/@waynestate/wsuheader/dist/header.html'
        ];

        // Outputs
        var output_blade = elixir.config.viewPath + '/partials';

        // Summary Reporting
        this.recordStep('Copying header');
        this.src = src_html;
        this.output = output_blade;

        // Copy and rename HTML
        return gulp.src(src_html)
            .pipe(rename({suffix: '.blade', extname: '.php'}))
            .pipe(gulp.dest(output_blade));
    });
});

// Handle Footer
elixir.extend('footer', function() {
    new elixir.Task('footer', function() {
        // Sources
        var src_html = [
            'node_modules/@waynestate/wsufooter/dist/footer.html'
        ];

        // Outputs
        var output_blade = elixir.config.viewPath + '/partials';

        // Summary Reporting
        this.recordStep('Copying footer');
        this.src = src_html;
        this.output = output_blade;

        // Copy and rename HTML
        return gulp.src(src_html)
            .pipe(rename({suffix: '.blade', extname: '.php'}))
            .pipe(gulp.dest(output_blade));
    });
});

// Copy over the HTTP Errors resources
elixir.extend('errors', function() {
    new elixir.Task('errors', function() {
        // Sources
        var src_css = [
            'vendor/waynestate/error-404/dist/404.css',
            'vendor/waynestate/error-404/dist/404.css.map',
            'vendor/waynestate/error-403/dist/403.css',
            'vendor/waynestate/error-403/dist/403.css.map',
            'vendor/waynestate/error-500/dist/500.css',
            'vendor/waynestate/error-500/dist/500.css.map',
        ];
        var src_images = [
            'vendor/waynestate/error-404/dist/404.png',
            'vendor/waynestate/error-403/dist/403.png',
            'vendor/waynestate/error-500/dist/500.png'
        ];
        var src_blade = [
            'vendor/waynestate/error-404/dist/404.php',
            'vendor/waynestate/error-403/dist/403.php',
            'vendor/waynestate/error-500/dist/500.php'
        ];

        // Outputs
        var output_css = 'public/_resources/css';
        var output_images = 'public/_resources/images';
        var output_blade = elixir.config.viewPath + '/errors';

        // Summary Reporting
        this.recordStep('Copying css files');
        this.recordStep('Copying images');
        this.recordStep('Copying blade templates');
        this.src = src_css.concat(src_images, src_blade);
        this.output = output_css + '\n' + output_images + '\n' + output_blade;

        // Copy CSS
        gulp.src(src_css)
            .pipe(gulp.dest(output_css));

        // Copy Images
        gulp.src(src_images)
            .pipe(gulp.dest(output_images));

        // Copy Blade Templates
        return gulp.src(src_blade)
            .pipe(rename({suffix: '.blade'}))
            .pipe(gulp.dest(output_blade));
    });
});

// Copy the .env file from .env.example if it doesn't exist
elixir.extend('dotenv', function() {
    new elixir.Task('dotenv', function() {
        // Summary Reporting
        this.recordStep('Copying example env');
        this.src = '.env.example';
        this.output = '.env';

        if(!fs.existsSync(this.output)) {
            return gulp.src(this.src)
                .pipe(rename(this.output))
                .pipe(gulp.dest(''));
        }
    });
});

// Create the _static symlink
elixir.extend('static_symlink', function() {
    new elixir.Task('static_symlink', function() {
        "use strict";

        let output = 'public/_static';
        let src = 'storage/app/public';

        // Summary Reporting
        this.src = src;
        this.output = output;
        this.recordStep('Create symbolic');

        return gulp.src(src)
            .pipe(sym(output, { force: true}));
    });
});

// Create the hook symlink
elixir.extend('hooks', function() {
    new elixir.Task('hooks', function() {
        "use strict";

        let output = '.git/hooks';
        let src = 'hooks/*';

        // Summary Reporting
        this.src = src;
        this.output = output;
        this.recordStep('Copying hooks to .git');

        // Copy Hooks
        return gulp.src(src)
            .pipe(gulp.dest(output))
    });
});

// Main Elixir
elixir(function(mix) {
    // Remove /node_modules/slick-carousel/slick/*.css to avoid conflicts
    del(['node_modules/slick-carousel/slick/*.css'])

    // Copy the header
    mix.header();

    // Copy the footer
    mix.footer();

    // Only run PHPLint when running on anything except production
    if (env != 'production') {
        // Lint PHP
        mix.phplint();
    }

    // Verify with Stylelint our SCSS meet our standards
    mix.stylelint();

    // Compile the SASS files
    mix.sass('main.scss', null, null, { includePaths: ['./node_modules/foundation-sites/scss/', './node_modules/'], outputStyle: 'compressed' });

    // Compile the JS files (if there's a webpack.config.js file in the root of the site, it will use that configuration)
    mix.webpack('main.js');

    // Copy the fonts to the public folder
    mix.copy_fonts();

    // Copy the images to the public folder
    mix.copy_images();

    // Copy the errors to the public folder
    mix.errors();

    // Handle the .env file, if needed
    mix.dotenv();

    // Build the _static symbolic folder link
    mix.static_symlink();

    // Copy in the git hooks
    mix.hooks();

    // Auto refresh web browser when changes take place
    mix.browserSync({
       proxy: 'https://' + package.name + '.wayne.dev'
    });

    // Only run these tasks when on running for production. Ex: "gulp --env=production"
    if (env == 'production') {
        // Version the CSS and JS file to the public/_resources/build folder
        mix.version(['css/main.css', 'js/main.js']);
    }
});
