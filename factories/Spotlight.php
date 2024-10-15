<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Spotlight implements FactoryContract
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
        $promo_group_id = $this->faker->randomNumber(5);

        for ($i = 0; $i <= $limit - 1; $i++) {
            $data[$i] = [
                'title' => $this->faker->name(),
                'excerpt' => $this->faker->jobTitle(),
                'description' => '<p>&ldquo;' . $this->faker->text(200) . '&rdquo;</p>',
                'link' => '#',
                'promo_item_id' => $i,
                'promo_group_id' => strval($promo_group_id),
                'relative_url' => '/styleguide/image/600x600?text=600x600:'.$i,
                'filename_url' => '/styleguide/image/600x600?text=600x600:'.$i,
                'filename_alt_text' => 'Placeholder image '.$i,
                'secondary_image' => '',
                'secondary_relative_url' => '/styleguide/image/150x150?text=150x150:'.$i, // 4:3
                'secondary_filename_url' => '',
                'secondary_alt_text' => 'Secondary placeholder image '.$i,
                'option' => '',
                //'option' => $this->faker->randomElement(['Gold', 'Green', '']),
                'start_date' => $this->faker->dateTimeThisMonth('now')->format('Y-m-d H:i:s'),
                'end_date' => '',
                'display_start_date' => '0000-00-00 00:00:00',
                'display_end_date' => '0000-00-00 00:00:00',
                'start_time_hide' => '0',
                'end_time_hide' => '0',
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
