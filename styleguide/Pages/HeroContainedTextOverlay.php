<?php

namespace Styleguide\Pages;

class HeroContainedTextOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroContainedTextOverlayController',
                'title' => 'Contained - Text overlay',
                'id' => 105100102,
            ],
        ]);
    }
}
