<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSListStyles extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSListStylesController',
                'title' => 'List styles',
                'id' => 100300,
            ],
        ]);
    }
}
