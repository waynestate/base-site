<?php

namespace Styleguide\Pages;

class NewsTopics extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'TopicController',
                'title' => 'Topic listing',
                'id' => 101103,
            ],
        ]);
    }
}
