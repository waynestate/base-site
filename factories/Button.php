<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Button implements FactoryContract
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
                'link' => '#',
                'title' => ucfirst(implode(' ', $this->faker->words(3))),
                //'excerpt' => $this->faker->catchPhrase,
                'description' => '',
                'promo_item_id' => $i,
                //'relative_url' => '/styleguide/image/100x100', // 1:1
                //'filename_url' => '/styleguide/image/100x100?text=100x100:'.$i, // 4:3
                //'filename_alt_text' => 'Placeholder image '.$i,
                //'secondary_image' => '',
                //'secondary_relative_url' => '/styleguide/image/150x150?text=150x150:'.$i, // 4:3
                //'secondary_filename_url' => '',
                //'secondary_alt_text' => 'Secondary placeholder image '.$i,
                'option' => '',
                //'option' => $this->faker->randomElement(['Gold', 'Green', '']),
                'group' => [
                    'title' => 'Promo group title',
                ],
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
