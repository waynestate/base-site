<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Accordion implements FactoryContract
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
                'title' => $this->faker->sentence,
                'description' => '<p>'.$this->faker->paragraph.'</p>',
            ];
        }

        return $data;
    }
}
