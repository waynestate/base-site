<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class AccordionItems implements FactoryContract
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
                'title' => $this->faker->sentence(),
                'description' => '<p>'.$this->faker->paragraph(5).' <a href="#">Example link.</a><ul><li>'.$this->faker->sentence().'</li><li>'.$this->faker->sentence().'</li><li>'.$this->faker->sentence().'</li></ul></p>',
                'promo_item_id' => $this->faker->numberBetween(1000, 10000),
                'relative_url' => $this->faker->randomElement([
                    '/styleguide/image/600x450?text=600x450', // 4:3
                    '/styleguide/image/450x600?text=450x600', // 3:4
                    '/styleguide/image/600x338?text=600x338', // 16:9
                    '/styleguide/image/600x600?text=600x600', // 1:1
                    '',
                ]),
                'filename_alt_text' => 'Placeholder image '.$i,
                'option' => $this->faker->randomElement(['Left','Right','Center','']),
                'excerpt' => $this->faker->sentence(),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
