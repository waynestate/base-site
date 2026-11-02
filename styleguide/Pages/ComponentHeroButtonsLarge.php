<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroButtonsLarge extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroButtonsController',
                'title' => 'Hero buttons (Large)',
                'id' => 105100115,
                'content' => [
                    'main' => '<p>You need to set up two components, <code>modular-hero</code> and <code>modular-hero-buttons</code> for the buttons to show.</p>',
                ],
            ],
        ]);
    }
}
