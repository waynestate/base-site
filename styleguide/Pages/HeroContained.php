<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroContained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Contained',
                'id' => 105100100,
            ],
        ]);
    }
}
