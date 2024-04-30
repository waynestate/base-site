<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSVideo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSVideoController',
                'title' => 'Video',
                'id' => 117100,
            ],
        ]);
    }
}
