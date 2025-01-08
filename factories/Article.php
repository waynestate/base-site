<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Article implements FactoryContract
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
        $data['data'] = app(ArticleComponent::class)->create($limit, $flatten, $options);

        $data['meta'] = app(ArticleMeta::class)->create(1, true);

        return $data;
    }
}
