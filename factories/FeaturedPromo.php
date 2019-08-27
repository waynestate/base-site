<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class FeaturedPromo implements FactoryContract
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
                'link' => 'https://wayne.edu',
                'relative_url' => '/styleguide/image/600x450?text=Featured',
                'title' => $this->faker->sentence,
                'excerpt' => $this->faker->sentence,
                'filename_alt_text' => 'Example featured image',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
