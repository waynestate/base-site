<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class NewsCategory implements FactoryContract
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
        $site_id = $this->faker->randomDigit;

        for ($i = 1; $i <= $limit; $i++) {
            $category = $this->faker->words(2, true);

            $data[$i] = [
                'category_id' => $i,
                'site_id' => $site_id,
                'is_active' => 1,
                'category' => $category,
                'slug' => str_slug($category),
            ];
        }

        return $data;
    }
}
