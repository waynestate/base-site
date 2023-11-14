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
                'description' => '<p>'.$this->faker->paragraph().' <a href="/styleguide">Example link.</a></p>',
                'promo_item_id' => $this->faker->numberBetween(1000, 10000),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
