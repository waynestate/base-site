<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Page implements FactoryContract
{
    /**
     * Construct the Page.
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
    public function create($limit = 1, $options = [])
    {
        // Set default values that need to be the same for every page on this site
        $site_id = $this->faker->randomDigit();
        $title = $this->faker->sentence($this->faker->numberBetween(2, 4));
        $menu_id = $this->faker->randomDigit();

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'site' => [
                    'id' => $site_id,
                    'title' => $title,
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
                    'id' => $menu_id,
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
