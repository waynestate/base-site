<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class GenericPromo implements FactoryContract
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
        $promo_group_id = $this->faker->randomNumber(5);

        for ($i = 0; $i <= ($limit - 1); $i++) {
            $data[$i] = [
                'title' => ucfirst(implode(' ', $this->faker->words(3))),
                'excerpt' => $this->faker->sentence,
                'description' => '<p>' . $this->faker->text(100) . ' <a href="https://wayne.edu">'. $this->faker->sentence(3)  .'</a></p>',
                'link' => 'https://wayne.edu',
                'promo_item_id' => strval($this->faker->randomNumber(5)),
                'promo_group_id' => strval($promo_group_id),
                'relative_url' => '/styleguide/image/600x450?text=600x450:'.$i, // 4:3
                //'relative_url' => '/styleguide/image/450x600', // 3:4
                //'relative_url' => '/styleguide/image/600x338', // 16:9
                //'relative_url' => '/styleguide/image/600x600', // 1:1
                //'relative_url' => '/styleguide/image/600x217', // 2.76:1
                //'relative_url' => '/styleguide/image/600x200', // 3:1
                'filename_url' => '/styleguide/image/600x450?text=600x450:'.$i, // 4:3
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
