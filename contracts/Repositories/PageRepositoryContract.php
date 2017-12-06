<?php

namespace Contracts\Repositories;

interface PageRepositoryContract
{
    /**
     * Find the JSON file path.
     *
     * @param $path
     * @return string
     */
    public function getFilename($path);
}
