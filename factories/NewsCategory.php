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
    public function create($limit = 1, $flatten = false, $options = [])
    {
        $site_id = $this->faker->randomDigit;

        for ($i = 1; $i <= $limit; $i++) {
            $category = $this->faker->words(2, true);

            $data[$i] = [
                'category_id' => $i,
                'site_id' => $site_id,
                'is_active' => 1,
                'category' => $category,
                'slug' => 'example',
                'link' => '/styleguide/news/category/example',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
