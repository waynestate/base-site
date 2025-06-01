<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class EmptyPromo implements FactoryContract
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

        $relative_url = '';

        for ($i = 0; $i <= $limit - 1; $i++) {
            $data[$i] = [
                'title' => ucfirst(implode(' ', $this->faker->words(6))),
                'excerpt' => '',
                'description' => '',
                'link' => '',
                'youtube_id' => '',
                'promo_item_id' => $i,
                'promo_group_id' => strval($promo_group_id),
                'relative_url' => '',
                'filename_url' => '',
                'filename_alt_text' => '',
                'secondary_relative_url' => '',
                'secondary_filename_url' => '',
                'secondary_alt_text' => '',
                'option' => '', // $option
                'start_date' => $this->faker->dateTimeThisMonth('now')->format('Y-m-d H:i:s'),
                'end_date' => '',
                'display_start_date' => '0000-00-00 00:00:00',
                'display_end_date' => '0000-00-00 00:00:00',
                'start_time_hide' => '0',
                'end_time_hide' => '0',
                'group' => [
                    'title' => 'Generic Promo Group',
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
