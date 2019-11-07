<?php

namespace Styleguide\Pages;

class HeroContainedRotate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Contained - Rotate',
                'id' => 105100101,
            ],
        ]);
    }
}
