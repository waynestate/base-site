<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ImageButton implements FactoryContract
{
    /**
     * Construct the ImageButton.
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
                'relative_url' => $this->faker->boolean === true ? '/styleguide/image/360x131' : '',
                'title' => $this->faker->sentence,
            ];
        }

        return $data;
    }
}
