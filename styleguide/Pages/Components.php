<?php

namespace Styleguide\Pages;

class Components extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Components',
                'id' => 102,
            ],
        ]);
    }
}
