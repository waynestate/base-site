<?php

namespace Styleguide\Pages;

class Styleguide extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'StyleGuideController',
                'title' => 'Content area',
                'id' => 100,
            ],
        ]);
    }
}
