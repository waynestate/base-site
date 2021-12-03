<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class EventsListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'EventsListingController',
                'title' => 'Events listing',
                'id' => 109100,
            ],
        ]);
    }
}
