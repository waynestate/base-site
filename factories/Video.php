<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Video implements FactoryContract
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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'link' => 'https://www.youtube.com/watch?v=PHqfwq033yQ',
                'youtube_id' => 'PHqfwq033yQ',
                'relative_url' => '',
                //'relative_url' => $this->faker->randomElement(['/styleguide/image/800x450?text=Video', '']),
                'title' => $this->faker->sentence(),
                'excerpt' => $this->faker->sentence(),
                'filename_alt_text' => 'Example video image',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
