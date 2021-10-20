<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Banner extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'BannerController',
                'title' => 'Banner',
                'id' => 112100,
            ],
        ]);
    }
}
