<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Tablestack extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'TableStackController',
                'title' => 'Table stack',
                'id' => 113100,
            ],
        ]);
    }
}
