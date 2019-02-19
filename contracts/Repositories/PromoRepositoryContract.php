<?php

namespace Contracts\Repositories;

interface PromoRepositoryContract
{
    /**
     * Get promotions for the homepage.
     *
     * @return array
     */
    public function getHomepagePromos(int $page_id);

    /**
     * Get promotions for the grid.
     *
     * @return array
     */
    public function getGridPromos(int $page_id);
}
