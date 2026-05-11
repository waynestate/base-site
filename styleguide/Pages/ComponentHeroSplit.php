<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroSplit extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero split',
                'id' => 105100109,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
