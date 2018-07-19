<?php

namespace Styleguide\Pages;

class Error500 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'Error500Controller',
                'title' => '500 page',
                'id' => 106100102,
            ],
        ]);
    }
}
