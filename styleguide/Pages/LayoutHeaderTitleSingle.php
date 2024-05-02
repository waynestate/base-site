<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutHeaderTitleSingle extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutHeaderTitleSingleController',
                'title' => 'Header title single',
                'id' => 102100100,
            ],
        ]);
    }
}
