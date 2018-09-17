<?php

namespace Contracts\Factories;

interface FactoryContract
{
    /**
     * Create data.
     *
     * @param int $limit
     * @param bool $flatten
     * @param array $options
     * @return array
     */
    public function create($limit, $flatten, $options);
}
