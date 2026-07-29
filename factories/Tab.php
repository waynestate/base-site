<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Tab implements FactoryContract
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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'title' => $this->faker->word(),
                'promo_item_id' => strval($this->faker->randomNumber(5)),
                'relative_url' => '/styleguide/image/800x600?text=800x600',
                'filename_alt_text' => 'Placeholder image',
                'description' => $this->faker->paragraph(8),
                'excerpt' => $this->faker->randomElement(['Image caption', '']),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
