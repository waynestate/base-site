<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Paginator extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PaginatorController',
                'title' => 'Paginator',
                'id' => 116101,
            ],
        ]);
    }
}
