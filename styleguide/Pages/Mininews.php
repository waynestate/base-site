<?php

namespace Styleguide\Pages;

class Mininews extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'MiniNewsController',
                'title' => 'Mini news',
                'id' => 110100,
            ],
            'site' => [
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);
    }
}
