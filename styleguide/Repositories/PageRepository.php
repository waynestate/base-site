<?php

namespace Styleguide\Repositories;

use App\Repositories\PageRepository as Repository;
use Contracts\Pages\StyleguidePageContract;
use Illuminate\Support\Facades\Storage;

class PageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getRequestData(array &$data)
    {
        return $this->getPageClass($data['parameters']['path'])->getPageData();
    }

    /**
     * Get the page classname based on the url path.
     */
    private function getPageClass(string $path): object
    {
        // Parse the path to break up each folder
        $parsedPath = collect(explode('/', $path));

        // Strip off styleguide since we aren't prefixing every filename with it
        $filename = $parsedPath->reject(function ($item) {
            return $item == 'styleguide';
        })->implode('');

        // If no filename is found then we are on the styleguide homepage
        if ($filename == '') {
            $filename = $parsedPath->implode('');
        }

        // A site page in Pages/Custom wins over the base page with the same name
        $class = collect([
            'styleguide/Pages/Custom' => 'Styleguide\Pages\Custom\\',
            'styleguide/Pages' => 'Styleguide\Pages\\',
        ])->map(function ($namespace, $folder) use ($filename) {
            // Compare against the filesystem so the URL's case doesn't matter
            $file = collect(Storage::disk('base')->files($folder))->first(function ($item) use ($filename) {
                return strtolower(basename($item)) === strtolower($filename).'.php';
            });

            return $file !== null ? $namespace.basename($file, '.php') : null;
        })->filter()->first();

        if ($class !== null) {
            $page = app($class);

            if ($page instanceof StyleguidePageContract) {
                return $page;
            }
        }

        abort('404');
    }
}
