<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class FooterContact implements FactoryContract
{
    /**
     * Construct the FooterContact.
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
    public function create($limit = 1)
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'link' => '/',
                'title' => $this->faker->sentence,
                'description' => '
                    <p>
                        ' .$this->faker->name.'<br />
                        ' .$this->faker->streetAddress.'<br />
                        ' .$this->faker->city.', '.$this->faker->state.' '.$this->faker->postcode.'<br />
                    </p>
                ',
            ];
        }

        return $data;
    }
}
