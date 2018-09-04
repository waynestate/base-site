<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Page implements FactoryContract
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
                'site' => [
                    'id' => 2,
                    'title' => 'Style guide',
                    'short-title' => '',
                    'keywords' => '',
                    'subsite-folder' => null,
                    'parent' => [
                        'id' => null,
                    ],
                ],
                'page' => [
                    'id' => $i,
                    'controller' => 'ChildpageController',
                    'title' => $this->faker->sentence(3),
                    'description' => '',
                    'content' => [
                        'main' => '',
                    ],
                    'keywords' => '',
                    'updated-at' => '',
                ],
                'menu' => [
                    'id' => 1,
                ],
                'data' => [],
            ];

            // Merge in overrides
            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit == 1) {
            return current($data);
        }

        return $data;
    }
}
