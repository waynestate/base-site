<?php

namespace Contracts\Repositories;

interface GridRepositoryContract
{
    /**
     * Get promotions for the grid.
     *
     * @return array
     */
    public function getGridPromos(array $data, $limit = 75);
}
