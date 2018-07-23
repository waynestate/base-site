<?php

namespace Styleguide\Pages;

class Error403 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'Error403Controller',
                'title' => '403 page',
                'id' => 106100100,
            ],
        ]);
    }
}
