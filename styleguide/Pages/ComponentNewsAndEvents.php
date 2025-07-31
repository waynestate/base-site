<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentNewsAndEvents extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentNewsAndEventsController',
                'title' => 'News and events',
                'id' => 124100,
            ],
            'site' => [
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
