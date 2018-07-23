<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ImageButton implements FactoryContract
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
    public function create($limit = 1, $flatten = false)
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'link' => $this->faker->url,
                'relative_url' => $this->faker->boolean === true ? '/styleguide/image/360x131?text=360x131%20('.$i.')' : '',
                'title' => $this->faker->sentence,
            ];
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
