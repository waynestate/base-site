<?php

namespace Contracts\Repositories;

interface FakeImageRepositoryContract
{
    /**
     * Create a fake image.
     *
     * @param string $size
     * @param string $text
     * @return string
     */
    public function create($size, $text);
}
