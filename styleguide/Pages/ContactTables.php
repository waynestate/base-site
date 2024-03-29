<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ContactTables extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'site' => [
                'people' => [
                    'site_id' => 1,
                ],
            ],
            'data' => [
                'profile_group_id' => '0,1,2,3',
            ],
            'page' => [
                'controller' => 'ContactTableController',
                'title' => 'Contact tables',
                'id' => 101113,
                'content' => ['main' => '<p>In order to choose which groups show:</p>
    <ol>
        <li>Add a custom field named "profile_group_id"</li>
        <li>Add in the IDs of the groups separated by the "," character</li>
        <li>Groups will be displayed in the order they are entered in the custom field</li>
    </ol>'],
            ],
        ]);
    }
}
