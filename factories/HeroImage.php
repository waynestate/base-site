<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class HeroImage implements FactoryContract
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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'relative_url' => '/styleguide/image/1600x580?text=1600x580%20('.$i.')',
                'title' => $this->faker->sentence,
                'description' => '<p>' . $this->faker->text(100) . ' <a href="#">'. $this->faker->sentence(3)  .'</a>',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
