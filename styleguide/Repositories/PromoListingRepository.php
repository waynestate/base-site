<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoListingRepository as Repository;

class PromoListingRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getPromoListingPromos(array $data, $limit = 75)
    {
        return [
            'listing_promos' => app('Factories\PromoListing')->create(15),
        ];
    }
}
