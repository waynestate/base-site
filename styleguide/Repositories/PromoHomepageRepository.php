<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoHomepageRepository as Repository;

class PromoHomepageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return [
            // Example Group
            //'key' => app('Factories\YourFactory')->create(5),
        ];
    }
}
