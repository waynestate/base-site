<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Profile implements FactoryContract
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker, ProfileGroup $group)
    {
        $this->faker = $faker->create();
        $this->group = $group;
    }

    /**
     * {@inheritdoc}
     */
    public function create($limit = 1, $flatten = false, $options = [])
    {
        $groups = collect($this->group->create(4));

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'data' => [
                    'AccessID' => $this->faker->randomLetter().$this->faker->randomLetter().$this->faker->randomNumber(4, true),
                    'First Name' => $this->faker->firstName(),
                    'Last Name' => $this->faker->lastName(),
                    'Title' => $this->faker->sentence(3),
                    'Picture' => [
                        'url' => '/styleguide/image/400x533?text=400x533%20('.$i.')',
                    ],
                    'Phone' => $this->faker->phoneNumber(),
                    'Email' => $this->faker->email(),
                    'Department' => '<p>'.$this->faker->sentence().'</p>',
                    'Office' => '<p>300 Prentis</p>',
                    'Biography' => '<p>'.$this->faker->paragraph(15).'</p>',
                    'Research Interests' => [
                        '<p>'.$this->faker->paragraph(10).'</p>',
                        '<p>'.$this->faker->paragraph(10).'</p>',
                        '<p>'.$this->faker->paragraph(10).'</p>',
                    ],
                    'Youtube Videos' => [
                        0 => 'https://www.youtube.com/watch?v=PHqfwq033yQ',
                    ],
                ],
                'groups' => [
                    $groups->random()['display_name'],
                ],
                'link' => '/styleguide/profile/aa0000',
            ];

            // Randomly include a suffix
            if (rand(0, 1) === 1) {
                $data[$i]['data']['Suffix'] = $this->faker->suffix();
            }

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
