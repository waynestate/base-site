<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FormsSlate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'Slate Form',
                'id' => 111100101,
                'content' => [
                    'main' => '<div id="form_35cc1a63-ef80-9d66-6cec-23cc284d0d15">Loading...</div>
                    <script async="async" src="https://gradslate.wayne.edu/register/?id=35cc1a63-ef80-9d66-6cec-23cc284d0d15&amp;output=embed&amp;div=form_35cc1a63-ef80-9d66-6cec-23cc284d0d15"></script>',
                ],
            ],
        ]);
    }
}
