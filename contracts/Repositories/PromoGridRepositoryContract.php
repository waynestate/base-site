<?php

namespace Contracts\Repositories;

interface PromoGridRepositoryContract
{
    /**
     * Get promotions for the grid.
     *
     * @return array
     */
    public function getGridPromos(array $data, $limit = 75);
}
