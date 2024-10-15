<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class EventFullListingNoImage implements FactoryContract
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
            $date = $this->faker->dateTimeBetween('+10 days', '+15 days')->format('Y-m-d');
            $title = $this->faker->sentence(rand(6, 10));

            $event = [
                'event_id' => $i,
                'url' => 'https://wayne.edu',
                'title' => $title,
                'date' => $date,
                'start_time' => $this->faker->time('H:i:s', 'now'),
                'end_time' => $this->faker->time('H:i:s', '+5 hours'),
                'repeat_end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
                'end_date' => $this->faker->dateTimeBetween('+10 days', '+15 days')->format('Y-m-d'),
                'images' => '',
                'is_all_day' => $this->faker->boolean(),
            ];
            $event = array_replace_recursive($event, $options);

            $data[$i] = $event;
        }

        return $data;
    }
}
