<?php

namespace Styleguide\Pages;

class HeaderShortTitleDouble extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeaderShortTitleDoubleController',
                'title' => 'Header title double w/short title',
                'id' => 102100103,
            ],
        ]);
    }
}
