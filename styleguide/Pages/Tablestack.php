<?php

namespace Styleguide\Pages;

class Tablestack extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'TableStackController',
                'title' => 'Table stack',
                'id' => 113100,
            ],
        ]);
    }
}
