<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutPageTitle extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutPageTitleController',
                'title' => 'Page title',
                'id' => 105100100,
            ],
        ]);
    }
}
