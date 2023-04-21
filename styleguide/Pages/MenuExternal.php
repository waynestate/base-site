<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class MenuExternal extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'Menu external',
                'id' => 103100102,
                'content' => [
                    'main' => '
                        <h2>Setup</h2>
                        <ul>
                            <li>Add class "external" to menu links and under-menu items</li>
                            <li>Suggestion: Use full url for any link considered external.</li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
