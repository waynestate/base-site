<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class VideoFull implements FactoryContract
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
                'link' => 'https://www.youtube.com/watch?v=QYVv994xz6s',
                'youtube_id' => 'QYVv994xz6s',
                'relative_url' => '/styleguide/image/1600x580?text=Video Full',
                'title' => $this->faker->sentence,
                'excerpt' => $this->faker->sentence,
                'description' => $this->faker->sentence,
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
