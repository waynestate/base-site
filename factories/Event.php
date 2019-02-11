<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Event implements FactoryContract
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
            $date = $this->faker->dateTimeThisMonth('now')->format('Y-m-d');
            $title = ($i !== 2)?$this->faker->sentence(rand(6, 10)):$title;

            $event = [
                'url' => $this->faker->url,
                'title' => $title,
                'date' => $date,
                'start_time' => $this->faker->dateTimeThisMonth('now')->format('H:i:s'),
                'is_all_day' => $this->faker->boolean,
            ];
            $event = array_replace_recursive($event, $options);

            $data[$date][] = $event;
        }

        if ($limit === 1 && $flatten === true) {
            foreach ($data as $date => $event) {
                $data[$date] = current($event);
            }
        }

        return $data;
    }
}
