<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class MiniList implements FactoryContract
{
    /**
     * Construct the MiniList.
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
                'title' => $this->faker->sentence,
            ];
        }

        return $data;
    }
}
