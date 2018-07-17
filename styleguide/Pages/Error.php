<?php

namespace Styleguide\Pages;

class Error extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Error pages',
                'id' => 106100,
            ],
        ]);
    }
}
