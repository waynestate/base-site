<?php

namespace Contracts\Factories;

interface FactoryContract
{
    /**
     * Create data.
     *
     * @param int $limit
     * @return array
     */
    public function create($limit);
}
