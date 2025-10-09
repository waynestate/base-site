<?php

namespace Styleguide\Repositories;

use App\Repositories\HomepageRepository as Repository;
use Contracts\Repositories\ModularPageRepositoryContract;
use Faker\Factory;

class HomepageRepository extends Repository
{
    /**
     * Construct the factory.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components,
    ) {
        $this->faker = $faker->create();
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(array $data): array
    {
        /*
        $promos = [
            'homepageItems' => app(\Factories\GenericPromo::class)->create(5, false),
        ];

        return $promos;
         */
    }

}
