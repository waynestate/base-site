<?php

namespace Styleguide\Pages;

class PromoGrid extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'PromoGridController',
                'title' => 'Promo grid',
                'id' => 101110,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
        ]);
    }
}
