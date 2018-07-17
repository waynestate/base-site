<?php

namespace Styleguide\Pages;

class HeroContainedRotate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Contained (rotate)',
                'id' => 105100101,
            ],
        ]);
    }
}
