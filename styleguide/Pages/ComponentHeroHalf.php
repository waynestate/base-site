<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroHalf extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero half',
                'id' => 105100109,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
