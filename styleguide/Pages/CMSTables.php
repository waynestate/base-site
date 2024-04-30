<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSTables extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSTablesController',
                'title' => 'Tables',
                'id' => 113100,
            ],
        ]);
    }
}
