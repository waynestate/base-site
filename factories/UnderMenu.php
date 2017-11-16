<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class UnderMenu implements FactoryContract
{
    /**
     * Construct the UnderMenu.
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
                'relative_url' => '//placehold.it/400x123',
                'title' => $this->faker->sentence,
            ];
        }

        return $data;
    }
}
