<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class DirectoryOrdered extends Page
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
                'profile_group_id' => '0,1',
            ],
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory ordered',
                'id' => 101108,
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
