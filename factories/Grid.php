<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Grid implements FactoryContract
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
        $promo_group_id = $this->faker->randomDigitNotNull();

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'relative_url' => '/styleguide/image/550x400?text=550x400',
                'title' => $this->faker->text(20),
                'link' => 'https://wayne.edu',
                'excerpt' => $this->faker->text(20),
                'promo_group_id' => $promo_group_id,
                'promo_item_id' => $i,
                'filename_alt_text' => 'Example grid image',
                'start_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
