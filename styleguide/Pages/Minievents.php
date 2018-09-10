<?php

namespace Styleguide\Pages;

class Minievents extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'MiniEventsController',
                'title' => 'Mini events',
                'id' => 109100,
            ],
        ]);
    }
}
