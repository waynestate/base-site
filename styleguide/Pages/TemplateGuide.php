<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class TemplateGuide extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'TemplateGuideController',
                'title' => 'Template guide',
                'id' => 101111,
                'content' => [
                    'main' => '<p class="text-lg">This guide will explain how to set up a custom template using components and columns.</p>',
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
