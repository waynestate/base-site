<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class PromoPage implements FactoryContract
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
        $image = '/styleguide/image/' . $this->faker->randomElement([
            '600x450?text=600x450', // 4:3
            '450x600?text=450x600', // 3:4
            '600x338?text=600x338', // 16:9
            '600x600?text=600x600', // 1:1
            //'600x217', // 2.76:1
            //'600x200', // 3:1
        ]);

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'title' => $this->faker->name(),
                'excerpt' => $this->faker->jobTitle(),
                'description' => '<p>' . $this->faker->text(70) . ' <a href="https://wayne.edu">'. $this->faker->sentence(3)  .'</a></p>',
                'link' => 'https://wayne.edu',
                'promo_item_id' => strval($this->faker->randomNumber(5)),
                'promo_group_id' => strval($promo_group_id),
                'option' => $this->faker->randomElement(['Gold', 'Green', '']),
                'relative_url' => $image.':'.$i,
                'filename_url' => $image.':'.$i,
                'filename_alt_text' => 'Placeholder image '.$i,
                'secondary_image' => '',
                'secondary_relative_url' => '/styleguide/image/150x150?text=150x150:'.$i, // 4:3
                'secondary_filename_url' => '',
                'secondary_alt_text' => 'Secondary placeholder image '.$i,
                'option' => '',
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
