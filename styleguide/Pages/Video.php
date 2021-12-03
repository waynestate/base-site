<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Video extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'VideoController',
                'title' => 'Video',
                'id' => 117100,
            ],
        ]);
    }
}
