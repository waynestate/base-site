<?php

namespace Styleguide\Pages;

class Minilist extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'MiniListController',
                'title' => 'Mini List',
                'id' => 111100,
            ],
        ]);
    }
}
