<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ApiError implements FactoryContract
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
    public function create($limit = 1, $flatten = false, $options = [])
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'error' => [
                    'status' => $this->faker->numberBetween(100, 199),
                    'message' => $this->faker->sentence,
                ],
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
