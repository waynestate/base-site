<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Buttons extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ButtonsComponentController',
                'title' => 'Button column',
                'id' => 114100,
                'content' => [
                    'main' => '
                    <p>This component can be used as buttons under the side menu and as buttons on your page.</p>
<p>You may not mix button types within a component.</p>
',
                ],
            ],
        ]);
    }
}
