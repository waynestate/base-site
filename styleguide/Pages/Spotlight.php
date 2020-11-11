<?php

namespace Styleguide\Pages;

class Spotlight extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'SpotlightController',
                'title' => 'Spotlight view',
                'id' => 101112,
            ],
        ]);
    }
}
