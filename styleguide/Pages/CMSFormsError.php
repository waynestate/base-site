<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSFormsError extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSFormsErrorController',
                'title' => 'Form Errors',
                'id' => 111100101,
            ],
        ]);
    }
}
