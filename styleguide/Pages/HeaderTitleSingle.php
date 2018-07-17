<?php

namespace Styleguide\Pages;

class HeaderTitleSingle extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'HeaderTitleSingleController',
                'title' => 'Header title single',
                'id' => 102100100,
            ],
        ]);
    }
}
