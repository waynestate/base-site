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
            $title = $this->faker->sentence(3);
            $picture = '/styleguide/image/400x533?text=400x533%20('.$i.')';
            $phone = $this->faker->phoneNumber;
            $department = '<p>'.$this->faker->sentence.'</p>';
            $office = '<p>300 Prentis</p>';
            $biography = '<p>'.$this->faker->paragraph(15).'</p>';
            $research_interests = [
                '<p>'.$this->faker->paragraph(10).'</p>',
                '<p>'.$this->faker->paragraph(10).'</p>',
                '<p>'.$this->faker->paragraph(10).'</p>',
            ];

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
                    [
                        'value' => $title,
                        'field' => [
                            'name' => 'Title',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $picture,
                        'field' => [
                            'name' => 'Picture',
                            'type' => 'file',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $phone,
                        'field' => [
                            'name' => 'Phone',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $department,
                        'field' => [
                            'name' => 'Department',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $office,
                        'field' => [
                            'name' => 'Office',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $biography,
                        'field' => [
                            'name' => 'Biography',
                            'type' => 'text',
                            'global' => 1,
                        ],
                    ],
                    [
                        'value' => $research_interests,
                        'field' => [
                            'name' => 'Research Interests',
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
                        'url' => $picture,
                    ],
                    'Phone' => $phone,
                    'Department' => $biography,
                    'Office' => $office,
                    'Biography' => $biography,
                    'Research Interests' => $research_interests,
                    'Youtube Videos' => [
                        0 => [
                            'youtube_id' => 'PHqfwq033yQ',
                            'link' => 'https://www.youtube.com/watch?v=PHqfwq033yQ',
                            'filename_alt_text' => 'YouTube video from '.$this->faker->firstName,
                        ],
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
