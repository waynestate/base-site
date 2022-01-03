<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class FooterContact implements FactoryContract
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
                'link' => '/',
                'title' => $this->faker->text(30),
                'description' =>
                    '<p>
                        ' .$this->faker->name.'<br />
                        ' .$this->faker->streetAddress.'<br />
                        ' .$this->faker->city.', '.$this->faker->state.' '.$this->faker->postcode.'<br />
                        <a href="https://wayne.edu">'.$this->faker->word.'</a>
                    </p>',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
