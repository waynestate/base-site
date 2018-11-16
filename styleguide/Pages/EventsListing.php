<?php

namespace Styleguide\Pages;

class EventsListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'EventsListingController',
                'title' => 'Events listing',
                'id' => 109100,
            ],
        ]);
    }
}
