<?php

namespace Styleguide\Pages;

class Mininews extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'MiniNewsController',
                'title' => 'Mini news',
                'id' => 110100,
            ],
        ]);
    }
}
