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
    public function getHomepagePromos(array $data): array
    {
        $promos = [
            'homepageItems' => app(\Factories\GenericPromo::class)->create(5, false),
            'components' => [
                'catalog-1' => [
                    'data' => app(\Factories\GenericPromo::class)->create(4, false),
                    'component' => [
                        'filename' => 'catalog-1',
                        'gradientOverlay' => true,
                    ],
                ],
            ],
        ];

        return $promos;
    }
}
