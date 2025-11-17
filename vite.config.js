import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

// Copy & Rename Blade Files and Replace date in Footer, necessary to do outside of mix.copy and webpack plugins due to
// file changes causing infinite loops during make watch.
if(!fs.existsSync('public/_resources/')) {
    fs.mkdir('public/_resources/', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('public/_resources/ directory created.');
    });
}
if(!fs.existsSync('resources/views/errors/')) {
    fs.mkdir('resources/views/errors/', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('resources/views/errors/ directory created.');
    });
}
if(!fs.existsSync('public/_resources/images/')) {
    fs.mkdir('public/_resources/images/', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('public/_resources/images/ directory created.');
    });
}
if(!fs.existsSync('public/_resources/css')) {
    console.log('public/_resources/css');
    fs.mkdir('./public/_resources/css', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('./public/_resources/css/ directory created.');
    });
}
fs.copyFileSync('node_modules/@waynestate/wsuheader/dist/header.html', 'resources/views/components/header.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('node_modules/@waynestate/wsufooter/dist/footer.html', 'resources/views/components/footer.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-404/dist/404.php', 'resources/views/errors/404.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-404/dist/404.css', 'public/_resources/css/404.css', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-404/dist/404.css.map', 'public/_resources/css/404.css.map', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-404/dist/404.png', 'public/_resources/images/404.png', fs.constants.COPYFILE_FICLONE);

fs.copyFileSync('vendor/waynestate/error-403/dist/403.php', 'resources/views/errors/403.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-403/dist/403.css', 'public/_resources/css/403.css', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-403/dist/403.css.map', 'public/_resources/css/403.css.map', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-403/dist/403.png', 'public/_resources/images/403.png', fs.constants.COPYFILE_FICLONE);

fs.copyFileSync('vendor/waynestate/error-429/dist/429.php', 'resources/views/errors/429.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-429/dist/429.css', 'public/_resources/css/429.css', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-429/dist/429.css.map', 'public/_resources/css/429.css.map', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-429/dist/429.png', 'public/_resources/images/429.png', fs.constants.COPYFILE_FICLONE);

fs.copyFileSync('vendor/waynestate/error-500/dist/500.php', 'resources/views/errors/500.blade.php', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-500/dist/500.css', 'public/_resources/css/500.css', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-500/dist/500.css.map', 'public/_resources/css/500.css.map', fs.constants.COPYFILE_FICLONE);
fs.copyFileSync('vendor/waynestate/error-500/dist/500.png', 'public/_resources/images/500.png', fs.constants.COPYFILE_FICLONE);

// Copy the pre-commit hook
if(!fs.existsSync('.git/hooks')) {
    fs.mkdir('.git/hooks', (err) => {
        if (err) {
            return console.error(err);
        }
        console.log('.git/hooks directory created.');
    });
}
fs.copyFileSync('hooks/pre-commit', '.git/hooks/pre-commit', fs.constants.COPYFILE_FICLONE);

// Replace year in footer file
const footerPath = 'resources/views/components/footer.blade.php';
if (fs.existsSync(footerPath)) {
    let footerContent = fs.readFileSync(footerPath, 'utf8');
    footerContent = footerContent.replace(/2\d{3}/g, "{{ date('Y') }}");
    fs.writeFileSync(footerPath, footerContent);
}

// Create the _static symlink
fs.symlink(
    path.resolve('./storage/app/public'),
    path.resolve('./public/_static'),
    function (err) { err != null && err.errno != -17 ? console.log(err) : console.log("./storage/app/public symlinked to ./public/_static/ created."); }
);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/main.css',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
    ],
});
