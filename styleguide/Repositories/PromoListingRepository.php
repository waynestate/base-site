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
            'promos' => app('Factories\PromoListing')->create(15),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoView($id)
    {
        return [
            'promo' => app('Factories\PromoListing')->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToSpotlightsListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/spotlightlisting';
    }
}
