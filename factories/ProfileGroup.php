<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ProfileGroup implements FactoryContract
{
    /**
     * Construct the ProfileGroup.
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
                'display_name' => $this->faker->word,
            ];
        }

        return $data;
    }
}
