<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ContactTablesNoTOC extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'data' => [
                'profile_group_id' => '0|1|2|3',
                'table_of_contents' => 'hide',
            ],
            'page' => [
                'controller' => 'ContactTableController',
                'title' => 'Contact tables, no table of contents',
                'id' => 101114,
                'content' => ['main' => '<p>In order to choose which groups show:</p>
    <ol>
        <li>Add a custom field named "profile_group_id"</li>
        <li>Add in the IDs of the groups separated by the "|" character</li>
        <li>Groups will be displayed in the order they are entered in the custom field</li>
    </ol>
    <p>In order to hide the table of contents:</p>
    <ol>
        <li>Add a custom field to the page named "table_of_contents"</li>
        <li>Set the value to "hide"</li>
    </ol>'],
            ],
        ]);
    }
}
