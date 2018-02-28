<?php

namespace Styleguide\Pages;

class Styleguide extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'StyleGuideController',
                'title' => 'Content Area',
                'id' => 100,
            ],
        ]);
    }
}
