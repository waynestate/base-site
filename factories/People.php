<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class People implements FactoryContract
{
    /**
     * Construct the factory.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker, PeopleGroup $group)
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
            $accessid = $this->faker->randomLetter.$this->faker->randomLetter.$this->faker->randomNumber(4, true);
            $first_name = $this->faker->firstName;
            $last_name = $this->faker->lastName;
            $email = $this->faker->email;
            $site_id = $options['site_id'] ?? 2;

            $data[$i] = [
                'id' => $i,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'accessid' => $accessid,
                'email' => $email,
                'sites' => [
                    'id' => $options['site_id'] ?? 2,
                    'cms_site_id' => 3,
                    'name' => 'Marketing and Communications',
                    'is_active' => 1,
                ],
                'field_data' => [
                    [
                        'value' => $first_name,
                        'field' => [
                            'name' => 'First Name',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $last_name,
                        'field' => [
                            'name' => 'Last Name',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $email,
                        'field' => [
                            'name' => 'Email',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                ],
                'groups' => [
                    $groups->random(),
                ],
                'link' => '/styleguide/profile/aa0000',
                'data' => [
                    'AccessID' => $accessid,
                    'First Name' => $first_name,
                    'Last Name' => $last_name,
                    'Email' => $email,
                    'Title' => $this->faker->sentence(3),
                    'Picture' => [
                        'url' => '/styleguide/image/400x533?text=400x533%20('.$i.')',
                    ],
                    'Phone' => $this->faker->phoneNumber,
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

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
