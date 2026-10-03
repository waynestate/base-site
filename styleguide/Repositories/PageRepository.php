<?php

namespace Styleguide\Repositories;

use App\Repositories\PageRepository as Repository;
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

        $siteNamespace = config('base.site_namespace', 'Site');
        $sitePagesDir = 'app/'.$siteNamespace.'/Styleguide/Pages';

        // Check site-specific styleguide pages first
        if (Storage::disk('base')->exists($sitePagesDir)) {
            $class_name = collect(Storage::disk('base')->allFiles($sitePagesDir))->filter(function ($item) use ($filename) {
                return strtolower(basename($item)) == strtolower($filename).'.php';
            })->map(function ($item) {
                return basename($item, '.php');
            })->first();

            if ($class_name != null) {
                $page = app('\\App\\'.$siteNamespace.'\\Styleguide\\Pages\\'.$class_name);

                if (in_array('Contracts\Pages\StyleguidePageContract', class_implements($page))) {
                    return $page;
                }
            }
        }

        // Compare the path's class_name to the filesystem so we can eliminate case sensitivity issues
        $class_name = collect(Storage::disk('base')->allFiles('styleguide/Pages'))->filter(function ($item) use ($filename) {
            return strtolower(basename($item)) == strtolower($filename).'.php';
        })->map(function ($item) {
            return basename($item, '.php');
        })->first();

        if ($class_name != null) {
            // Construct the page object
            $page = app('\Styleguide\Pages\\'.$class_name);

            // Make sure it impelments the proper contract
            if (in_array('Contracts\Pages\StyleguidePageContract', class_implements($page))) {
                return $page;
            }
        }

        abort('404');
    }
}
