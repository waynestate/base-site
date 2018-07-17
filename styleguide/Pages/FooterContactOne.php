<?php

namespace Styleguide\Pages;

class FooterContactOne extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FooterContactOneController',
                'title' => 'One column',
                'id' => 104100100,
            ],
        ]);
    }
}
