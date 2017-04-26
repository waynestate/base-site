<?php

namespace Contracts\Repositories;

interface PromoRepositoryContract
{
    /**
     * Get promotions for the homepage.
     *
     * @return array
     */
    public function getHomepagePromos();
}
