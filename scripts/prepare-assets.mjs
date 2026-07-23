import fs from 'fs';
import path from 'path';

// Copy Blade files from node_modules/vendor packages.
// Done as a standalone script step (not a Vite plugin) to avoid infinite loops
// during development — file changes watched by Vite would re-trigger the copies.
fs.copyFileSync(
    'node_modules/@waynestate/wsuheader/dist/header.html',
    'resources/views/components/header.blade.php',
    fs.constants.COPYFILE_FICLONE,
);
fs.copyFileSync(
    'node_modules/@waynestate/wsufooter/dist/footer.html',
    'resources/views/components/footer.blade.php',
    fs.constants.COPYFILE_FICLONE,
);
fs.copyFileSync(
    'vendor/waynestate/error-404/dist/404.php',
    'resources/views/errors/404.blade.php',
    fs.constants.COPYFILE_FICLONE,
);
fs.copyFileSync(
    'vendor/waynestate/error-403/dist/403.php',
    'resources/views/errors/403.blade.php',
    fs.constants.COPYFILE_FICLONE,
);
fs.copyFileSync(
    'vendor/waynestate/error-429/dist/429.php',
    'resources/views/errors/429.blade.php',
    fs.constants.COPYFILE_FICLONE,
);
fs.copyFileSync(
    'vendor/waynestate/error-500/dist/500.php',
    'resources/views/errors/500.blade.php',
    fs.constants.COPYFILE_FICLONE,
);

// Replace hardcoded years in the footer with a Blade date expression.
const footerPath = 'resources/views/components/footer.blade.php';
if (fs.existsSync(footerPath)) {
    let footerContent = fs.readFileSync(footerPath, 'utf8');
    footerContent = footerContent.replace(/2\d{3}/g, "{{ date('Y') }}");
    fs.writeFileSync(footerPath, footerContent);
}

// Install the dev-only git pre-commit hook.
if (process.env.NODE_ENV !== 'production') {
    if (!fs.existsSync('.git/hooks')) {
        fs.mkdirSync('.git/hooks', { recursive: true });
        console.log('.git/hooks directory created.');
    }

    fs.copyFileSync(
        'hooks/pre-commit',
        '.git/hooks/pre-commit',
        fs.constants.COPYFILE_FICLONE,
    );
}

// Create the public/_static -> storage/app/public symlink.
const target = path.resolve('./storage/app/public');
const link = path.resolve('./public/_static');

try {
    fs.symlinkSync(target, link, 'dir');
    console.log('./storage/app/public symlinked to ./public/_static/ created.');
} catch (err) {
    // EEXIST (errno -17 on macOS/Linux): symlink already exists, ignore.
    if (err.code !== 'EEXIST') {
        throw err;
    }
}
