<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Profile implements FactoryContract
{
    /**
     * Construct the factory.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker, ProfileGroup $group)
    {
        $this->faker = $faker->create();
        $this->group = $group;
    }

    /**
     * {@inheritdoc}
     */
    public function create($limit = 1, $flatten = false)
    {
        $groups = collect($this->group->create(4));

        for ($i = 1; $i <= $limit; $i++) {
            $accessid = $this->faker->randomLetter.$this->faker->randomLetter.$this->faker->randomNumber(4, true);

            $data[$i] = [
                'data' => [
                    'AccessID' => $accessid,
                    'First Name' => $this->faker->firstName,
                    'Last Name' => $this->faker->lastName,
                    'Title' => $this->faker->sentence(3),
                    'Picture' => [
                        'url' => '/styleguide/image/550x400?text='.$i,
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
                'groups' => [
                    $groups->random()['display_name'],
                ],
                'link' => '/styleguide/profile/'.$accessid,
            ];
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
