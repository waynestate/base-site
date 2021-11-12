<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ProgramListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ProgramListingController',
                'title' => 'Program listing',
                'id' => 100300,
            ],
        ]);
    }
}
