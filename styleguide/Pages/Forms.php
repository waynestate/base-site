<?php

namespace Styleguide\Pages;

class Forms extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FormsController',
                'title' => 'Forms',
                'id' => 112100,
            ],
        ]);
    }
}
