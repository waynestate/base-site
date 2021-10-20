<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FooterContactOne extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FooterContactOneController',
                'title' => 'One column',
                'id' => 104100100,
            ],
        ]);
    }
}
