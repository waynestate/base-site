<?php

namespace Styleguide\Pages;

class HeroFullDescriptionOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullDescriptionOverlayController',
                'title' => 'Full width (Description overlay)',
                'id' => 105100109,
            ],
        ]);
    }
}
