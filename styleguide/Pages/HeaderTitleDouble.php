<?php

namespace Styleguide\Pages;

class HeaderTitleDouble extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeaderTitleDoubleController',
                'title' => 'Header title double',
                'id' => 102100101,
            ],
        ]);
    }
}
