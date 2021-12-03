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
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getPromoListingPromos(array $data, $limit = 75);
}
