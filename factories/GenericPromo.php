<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class GenericPromo implements FactoryContract
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

        $relative_url = '/styleguide/image/' . $this->faker->randomElement([
            '600x450?text=600x450', // 4:3
            '450x600?text=450x600', // 3:4
            '600x338?text=600x338', // 16:9
            '600x600?text=600x600', // 1:1
            //'600x217', // 2.76:1
            //'600x200', // 3:1
        ]);


        for ($i = 0; $i <= $limit - 1; $i++) {
            $video = $this->faker->boolean(33);

            $title = $this->faker->randomElement([
                ucfirst(implode(' ', $this->faker->words(6))),
                $this->faker->name(),
            ]);

            $excerpt = $this->faker->randomElement([
                $this->faker->catchPhrase,
                $this->faker->jobTitle(),
            ]);

            $option = $this->faker->randomElement(['Green', 'Gold', '']);

            $data[$i] = [
                'title' => $title,
                'excerpt' => $excerpt,
                'description' => '<p>' . $this->faker->text(100) . ' <a href="https://wayne.edu">'. $this->faker->sentence(3)  .'</a></p>',
                'link' => (!empty($video) && $video === true) ? 'https://www.youtube.com/watch?v=PHqfwq033yQ' : '#',
                'youtube_id' => (!empty($video) && $video === true) ? 'PHqfwq033yQ' : null,
                'promo_item_id' => $i,
                'promo_group_id' => strval($promo_group_id),
                'relative_url' => $relative_url.':'.$i,
                'filename_url' => $relative_url.':'.$i,
                'filename_alt_text' => 'Placeholder image '.$i,
                'secondary_relative_url' => '',
                'secondary_filename_url' => '',
                'secondary_alt_text' => 'Secondary placeholder image '.$i,
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
