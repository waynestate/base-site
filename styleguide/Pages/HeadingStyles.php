<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeadingStyles extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeadingStylesController',
                'title' => 'Heading styles',
                'id' => 100900,
            ],
        ]);
    }
}
