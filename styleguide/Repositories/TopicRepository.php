<?php

namespace Styleguide\Repositories;

use App\Repositories\TopicRepository as Repository;

class TopicRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function listing($application_ids)
    {
        return [
            'topics' => app('Factories\Topic')->create(20),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $slug)
    {
        return [
            'topics' => app('Factories\Topic')->create(1, true),
        ];
    }
}
