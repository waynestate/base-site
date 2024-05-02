<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentEventListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentEventListingController',
                'title' => 'Events listing',
                'id' => 109100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
