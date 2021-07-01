<?php

namespace Contracts\Repositories;

interface PromoListingRepositoryContract
{
    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getPromoListingPromos(array $data, $limit = 75);
}
