<?php

namespace Styleguide\Pages;

class HeroContained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Contained',
                'id' => 105100100,
            ],
        ]);
    }
}
