<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSHeadingStyles extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSHeadingStylesController',
                'title' => 'Heading styles',
                'id' => 100900,
            ],
        ]);
    }
}
