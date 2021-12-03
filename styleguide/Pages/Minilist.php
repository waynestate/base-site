<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Minilist extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MiniListController',
                'title' => 'Mini list',
                'id' => 110100,
            ],
        ]);
    }
}
