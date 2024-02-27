<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutContainedHero extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutController',
                'title' => 'Contained hero layout',
                'id' => 120100101,
            ],
        ]);
    }
}
