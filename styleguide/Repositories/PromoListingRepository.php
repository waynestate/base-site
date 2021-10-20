<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoListingRepository as Repository;
use Factories\PromoListing;

class PromoListingRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getPromoListingPromos(array $data, $limit = 75)
    {
        return [
            'promos' => app(PromoListing::class)->create(15),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoView($id)
    {
        return [
            'promo' => app(PromoListing::class)->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/promolisting';
    }
}
