<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeaderShortTitleSingle extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeaderShortTitleSingleController',
                'title' => 'Header title single w/short title',
                'id' => 102100102,
            ],
        ]);
    }
}
