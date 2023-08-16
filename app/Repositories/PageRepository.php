<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Contracts\Repositories\RequestDataRepositoryContract;
use Contracts\Repositories\PageRepositoryContract;

class PageRepository implements RequestDataRepositoryContract, PageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {
        // Page data to return
        $pageData = [];

        // Set the path
        $path = !empty($data['parameters']['path']) ? $data['parameters']['path'] : '/';

        // Get the filename
        $filename = $this->getFilename($path);

        if (Storage::disk('public')->exists($filename)) {
            return json_decode(Storage::disk('public')->get($filename), true);
        } elseif ($data['server']['path'] === '/') {
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
    public function getFilename($path): string
    {
        // Handle the root homepage case since its refered to as index
        $path = $path == '/' ? 'index' : $path;

        return str_replace('/', '_', $path).'.json';
    }
}
