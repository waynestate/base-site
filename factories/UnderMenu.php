<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class UnderMenu implements FactoryContract
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
                'title' => ucfirst(implode(' ', $this->faker->words(2))),
                'excerpt' => ucfirst(implode(' ', $this->faker->words(3))),
                'option' => '',
            ];
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
