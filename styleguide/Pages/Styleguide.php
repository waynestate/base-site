<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Styleguide extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'StyleGuideController',
                'title' => 'Content area',
                'id' => 100100,
            ],
        ]);
    }
}
