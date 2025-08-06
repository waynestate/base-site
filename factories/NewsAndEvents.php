<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class NewsAndEvents implements FactoryContract
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
        $articles['articles'] = app(Article::class)->create(5);

        $events['events'] = app(Event::class)->create(5);

        // Put random stlyeguide dates in order
        if (!empty($events['events'])) {
            $events['events'] = collect($events['events'])->sortBy(function ($item, $key) {
                return $key;
            })->toArray();
        } else {
            $events = [];
        }

        $data['events'] = $events['events'] ?? [];
        $data['news'] = $articles['articles']['data'] ?? [];

        return $data;
    }
}
