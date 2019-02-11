<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Topic implements FactoryContract
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
            $data['data'][$i] = [
                'topic_id' => $i,
                'name' => $this->faker->words(2, true),
                'slug' => 'topic-example',
                'url' => '/styleguide/'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/topic-example',
            ];

            $data['data'][$i] = array_replace_recursive($data['data'][$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            $data['data'] = current($data['data']);
        }

        $data['meta']['total'] = count($data['data']);

        return $data;
    }
}
