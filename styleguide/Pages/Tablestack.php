<?php

namespace Styleguide\Pages;

class Tablestack extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'TableStackController',
                'title' => 'Table Stack',
                'id' => 115100,
            ],
        ]);
    }
}
