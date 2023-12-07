<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ChildpageWithComponents extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Childpage with components',
                'id' => 101110700,
                'content' => [
                    'main' => '<p>Normal page content from the CMS will show up here and components will display below.</p><p>See the <a href="/styleguide/usingcomponents">Using components</a> page for configuration details.</p>',
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
            ],
            'data' => [
                'modular-catalog' => '{}',
            ],
        ]);
    }
}
