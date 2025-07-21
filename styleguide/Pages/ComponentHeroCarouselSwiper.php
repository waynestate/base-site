<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroCarouselSwiper extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero carousel (Swiper)',
                'id' => 105100104,
                'content' => [
                    'main' => '',
                ],
            ],
            'heroCarouselType' => 'swiper',
        ]);
    }
}
