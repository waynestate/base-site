<?php

namespace Styleguide\Pages;

class FooterContactTwo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'FooterContactTwoController',
                'title' => 'Two column',
                'id' => 104100101,
            ],
        ]);
    }
}
