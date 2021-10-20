<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeaderShortTitleDouble extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeaderShortTitleDoubleController',
                'title' => 'Header title double w/short title',
                'id' => 102100103,
            ],
        ]);
    }
}
