<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;
use Storage;

class Page implements FactoryContract
{
    /**
     * Construct the factory.
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
        $package_json = Storage::disk('base')->get('package.json');
        $base_info = json_decode($package_json, true);

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'site' => [
                    'id' => 2,
                    'title' => 'Base - Style guide (v'.($base_info['baseVersion'] ?? $base_info['version']).')',
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

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit == 1) {
            return current($data);
        }

        return $data;
    }
}
