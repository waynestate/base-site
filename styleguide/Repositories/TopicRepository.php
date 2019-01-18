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
        $topics['topics'] = app('Factories\Topic')->create(20);

        if (!empty($topics['topics']['data'])) {
            $topics['topics']['data'] = $this->sortByLetter($topics['topics']['data']);
        }

        return $topics;
    }

    /**
     * {@inheritdoc}
     */
    public function find($slug)
    {
        return [
            'topics' => app('Factories\Topic')->create(1, true),
        ];
    }
}
