<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSForms extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSFormsController',
                'title' => 'Forms',
                'id' => 111100100,
            ],
        ]);
    }
}
