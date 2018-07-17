<?php

namespace Styleguide\Pages;

class Error404 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'Error404Controller',
                'title' => '404 page',
                'id' => 106100101,
            ],
        ]);
    }
}
