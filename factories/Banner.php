<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Banner implements FactoryContract
{
    /**
     * Construct the Banner.
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
                'class' => 'banner',
                'title' => 'Make a',
                'link' => $this->faker->url,
                'excerpt' => 'Gift',
            ];
        }

        if ($limit == 1) {
            return current($data);
        }

        return $data;
    }
}
