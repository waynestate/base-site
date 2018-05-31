<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class FooterSocial implements FactoryContract
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
    public function create($limit = 1)
    {
        $data = [
            1 => [
                'link' => $this->faker->url,
                'title' => 'twitter',
            ],
            2 => [
                'link' => $this->faker->url,
                'title' => 'facebook',
            ],
            3 => [
                'link' => $this->faker->url,
                'title' => 'instagram',
            ],
            4 => [
                'link' => $this->faker->url,
                'title' => 'linkedin',
            ],
            5 => [
                'link' => $this->faker->url,
                'title' => 'flickr',
            ],
            6 => [
                'link' => $this->faker->url,
                'title' => 'pinterest',
            ],
            7 => [
                'link' => $this->faker->url,
                'title' => 'youtube',
            ],
        ];

        // Make sure they aren't requesting more icons that we have available
        if ($limit > count($data)) {
            $limit = count($data);
        }

        $data = array_slice($data, 0, $limit);

        return $data;
    }
}
