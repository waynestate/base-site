<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ProfileGroup implements FactoryContract
{
    /**
     * Construct the factory.
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
                'parent_id' => 0,
                'display_order' => $i,
                'display_name' => ucfirst($this->faker->words(2, true)),
            ];
        }

        return $data;
    }
}
