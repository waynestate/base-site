<?php

namespace Styleguide\Pages;

class HeroContained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Hero Contained',
                'id' => 105100100,
            ],
        ]);
    }
}
