<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Event implements FactoryContract
{
    /**
     * Construct the Event.
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
                'url' => $this->faker->url,
                'title' => $this->faker->sentence(rand(6, 10)),
                'date' => $this->faker->dateTimeThisMonth('now')->format('Y-m-d H:i:s'),
                'start_time' => $this->faker->dateTimeThisMonth('now')->format('Y-m-d H:i:s'),
                'is_all_day' => $this->faker->boolean,
            ];
        }

        return $data;
    }
}
