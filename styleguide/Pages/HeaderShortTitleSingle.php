<?php

namespace Styleguide\Pages;

class HeaderShortTitleSingle extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeaderShortTitleSingleController',
                'title' => 'Header title single w/short title',
                'id' => 102100102,
            ],
        ]);
    }
}
