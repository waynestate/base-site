<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Catalog implements FactoryContract
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
        // Doc https://github.com/fzaninotto/Faker

        $promo_group_id = $this->faker->randomNumber(5);

        $relative_url = '/styleguide/image/600x600?text=600x600'; // 1:1


        for ($i = 0; $i <= $limit - 1; $i++) {
            $data[$i] = [
                'title' => 'Call to action',
                'link' => '#',
                'promo_item_id' => $i,
                'promo_group_id' => strval($promo_group_id),
                'relative_url' => $relative_url.':'.$i,
                'filename_url' => $relative_url.':'.$i,
                'filename_alt_text' => 'Placeholder image '.$i,
                'group' => [
                    'title' => 'Modular Catalog Promotion Group',
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
