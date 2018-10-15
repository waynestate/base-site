<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class NewsItem implements FactoryContract
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
                'news_id' => $i,
                'app_id' => $this->faker->randomDigit,
                'slug' => $this->faker->slug,
                'title' => $this->faker->sentence(rand(6, 10)),
                'posted' => $this->faker->date,
                'excerpt' => '',
                'archive' => 1,
                'link' => '',
                'full_link' => '/styleguide/'.config('base.news_view_route').'/item-1',
                'body' => $this->faker->paragraph,
                'filename' => '',
                'categories' => null,
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
