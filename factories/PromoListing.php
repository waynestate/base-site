<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class PromoListing implements FactoryContract
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
        $promo_group_id = $this->faker->numberBetween(1, 200);

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'promo_item_id' => $i,
                'promo_group_id' => $promo_group_id,
                'relative_url' => '/styleguide/image/300x400?text=300x400',
                'title' => $this->faker->name,
                'link' => 'https://wayne.edu',
                'excerpt' => $this->faker->sentence,
                'description' => '<p>'.$this->faker->paragraph.'</p>'.'<p>'.$this->faker->paragraph.'</p>'.'<p>'.$this->faker->paragraph.'</p>',
                'filename_alt_text' => 'Example grid image',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
