<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ArticleMeta implements FactoryContract
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
        $data = [
            'total' => '',
            'per_page' => '',
            'current_page' => '',
            'last_page' => 3,
            'next_page_url' => '',
            'prev_page_url' => '',
        ];

        return $data;
    }
}
