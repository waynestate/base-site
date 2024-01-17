<?php

namespace Styleguide\Repositories;

use App\Repositories\HomepageRepository as Repository;
use Faker\Factory;

class HomepageRepository extends Repository
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(int $page_id = null)
    {
        return [
            //'key' => app(\Factories\YourFactory::class)->create(5),
            'promos' => app(\Factories\GenericPromo::class)->create(5),
        ];
    }
}
