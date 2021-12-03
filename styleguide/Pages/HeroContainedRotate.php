<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroContainedRotate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Contained - Rotate',
                'id' => 105100101,
            ],
        ]);
    }
}
