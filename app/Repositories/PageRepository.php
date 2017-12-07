<?php

namespace App\Repositories;

use Contracts\Repositories\DataRepositoryContract;
use Contracts\Repositories\PageRepositoryContract;

class PageRepository implements DataRepositoryContract, PageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {
        // Page data to return
        $pageData = [];

        // Set the path
        $path = isset($data['parameters']['path']) ? $data['parameters']['path'] : '/';

        // Get the filename
        $filename = $this->getFilename($path);

        // Get the raw JSON
        if (file_exists(storage_path().'/app/public/'.$filename)) {
            $json = file_get_contents(storage_path().'/app/public/'.$filename);

            // Decode the JSON
            $pageData = json_decode($json, true);

            return $pageData;
        } elseif (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/') {
            // Forward them to the styleguide if no homepage is found
            return redirect('/styleguide');
        }

        return abort('404');
    }

    /**
     * Find the JSON file path.
     *
     * @param $path
     * @return string
     */
    public function getFilename($path)
    {
        // Handle the root homepage case since its refered to as index
        $path = $path == '/' ? 'index' : $path;

        return str_replace('/', '_', $path).'.json';
    }
}
