<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ProfileGroup implements FactoryContract
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
    public function create($limit = 1, $flatten = false, $options = [])
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'id' => $i,
                'parent_id' => 0,
                'display_order' => $i,
                'display_name' => ucfirst($this->faker->words(2, true)),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
