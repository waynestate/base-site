<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Profile implements FactoryContract
{
    /**
     * Construct the Profile.
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
                'data' => [
                    'AccessID' => 'aa0000',
                    'First Name' => $this->faker->firstName,
                    'Last Name' => $this->faker->lastName,
                    'Title' => $this->faker->sentence(3),
                    'Picture' => [
                        'url' => '/_resources/images/no-photo.svg',
                    ],
                    'Phone' => $this->faker->phoneNumber,
                    'Email' => $this->faker->email,
                    'Department' => '<p>'.$this->faker->sentence.'</p>',
                    'Office' => '<p>300 Prentis</p>',
                    'Biography' => '<p>'.$this->faker->paragraph(15).'</p>',
                    'Research Interests' => [
                        '<p>'.$this->faker->paragraph(10).'</p>',
                        '<p>'.$this->faker->paragraph(10).'</p>',
                        '<p>'.$this->faker->paragraph(10).'</p>',
                    ],
                ],
            ];
        }

        if ($limit == 1) {
            return current($data);
        }

        return $data;
    }
}
