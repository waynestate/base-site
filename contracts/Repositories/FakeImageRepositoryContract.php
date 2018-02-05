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

    /**
     * Parse the size for the height and width.
     *
     * @param string $size
     * @return array
     */
    public function dimensions($size);

    /**
     * Block images that are to large.
     *
     * @param array $dimensions
     * @return boolean
     */
    public function reasonableSize($dimensions);

    /**
     * Check if the request is from the same domain to prevent hotlinking images.
     *
     * @param string $host
     * @param string $referer
     * @return boolean
     */
    public function onSameHost($host, $referer);
}
