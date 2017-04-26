<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class HeroImage implements FactoryContract
{
    /**
     * Construct the HeroImage.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function create($limit = 1)
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'link' => $this->faker->url,
                'relative_url' => '//placehold.it/1600x580',
                'title' => $this->faker->sentence,
            ];
        }

        return $data;
    }
}
