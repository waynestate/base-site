<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroCarousel extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero carousel',
                'id' => 105100104,
                'content' => [
                    'main' => '<p class="mb-6">Enable the Hero Carousel by adding a hero component with a limit greater than 1.</p><p></p>',
                ],
            ],
        ]);
    }
}
