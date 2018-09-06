<?php

namespace Styleguide\Pages;

class UnderMenu extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'UnderMenuController',
                'title' => 'Under menu',
                'id' => 116100,
            ],
        ]);
    }
}
