<?php

namespace Styleguide\Repositories;

use App\Repositories\TopicRepository as Repository;
use Factories\Topic;

class TopicRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function listing(int|array $application_ids, $subsite_folder = null): array
    {
        $topics['topics'] = app(Topic::class)->create(20);

        return $topics;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $slug): array
    {
        return [
            'topics' => app(Topic::class)->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setSelected(array $topics, ?string $topic): array
    {
        return collect($topics)->map(function ($item, $key) {
            $item['selected'] = $key === 1 ? true : false;

            return $item;
        })->toArray();
    }
}
