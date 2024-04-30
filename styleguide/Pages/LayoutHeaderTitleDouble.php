<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeaderTitleDouble extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeaderTitleDoubleController',
                'title' => 'Header title double',
                'id' => 102100101,
            ],
        ]);
    }
}
