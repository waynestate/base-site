<?php

namespace Styleguide\Pages;

class FooterContactFour extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'FooterContactFourController',
                'title' => 'Four column',
                'id' => 104100103,
            ],
        ]);
    }
}
