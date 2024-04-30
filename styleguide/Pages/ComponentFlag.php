<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentFlag extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentFlagController',
                'title' => 'Flag',
                'id' => 112100,
            ],
        ]);
    }
}
