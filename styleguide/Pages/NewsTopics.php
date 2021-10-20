<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class NewsTopics extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'TopicController',
                'title' => 'Topic listing',
                'id' => 101104,
            ],
            'site' => [
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
