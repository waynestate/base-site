<?php

namespace Styleguide\Pages;

class Spotlights extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'SpotlightController',
                'title' => 'Spotlights',
                'id' => 101111,
            ],
        ]);
    }
}
