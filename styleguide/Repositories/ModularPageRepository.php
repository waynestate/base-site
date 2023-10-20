<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularPromos(array $data)
    {
        $promos['button-row'] = app(GenericPromo::class)->create(3, false, [
            'component' => [
                'heading' => 'Button row',
                'filename' => 'button-row',
            ]
        ]);

        $promos['content-row-1'] = app(GenericPromo::class)->create(2, false, [
            'title' => 'Promo item title (h3)',
            'component' => [
                'heading' => 'Content row - with heading',
                'filename' => 'content-row'
            ]
        ]);

        $promos['content-row-2'] = app(GenericPromo::class)->create(2, false, [
            'title' => 'Promo item title (content row - no heading)',
            'component' => [
                'filename' => 'content-row',
            ]
        ]);

        $promos['catalog-1'] = app(GenericPromo::class)->create(3, false, [
            'description' => '',
            'component' => [
                'heading' => 'Catalog with three columns',
                'columns' => 3,
                'filename' => 'catalog',
                'showExcerpt' => true,
                'singlePromoView' => true,
            ]
        ]);

        $promos['catalog-2'] = app(GenericPromo::class)->create(4, false, [
            'description' => '',
            'component' => [
                'heading' => 'Catalog with four columns',
                'columns' => 4,
                'filename' => 'catalog',
                'showExcerpt' => true,
                'singlePromoView' => true,
            ]
        ]);

        $promos['catalog-3'] = app(GenericPromo::class)->create(2, false, [
            'excerpt' => '',
            'component' => [
                'heading' => 'Catalog with one column',
                'columns' => '1',
                'filename' => 'catalog',
                'showExcerpt' => false,
                'singlePromoView' => true,
            ]
        ]);

        $promos['accordion-1'] = app(GenericPromo::class)->create(3, false, [
            'component' => [
                'heading' => 'Accordion 1',
                'filename' => 'accordion',
            ]
        ]);

        $promos['accordion-2'] = app(GenericPromo::class)->create(4, false, [
            'component' => [
                'heading' => 'Accordion 2',
                'filename' => 'accordion',
            ]
        ]);

        $promos['button-column'] = app(GenericPromo::class)->create(3, false, [
            'component' => [
                'heading' => 'Button column',
                'filename' => 'button-column'
            ]
        ]);

        $promos['image-column'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Image column',
                'filename' => 'image-column'
            ]
        ]);

        /*
        $promos['content-column-1'] = app(GenericPromo::class)->create(1, false, [
            'title' => 'Content column (promo item title)',
            'component' => [
                'filename' => 'content-column',
            ]
        ]);

        $promos['content-column-2'] = app(GenericPromo::class)->create(1, false, [
            'title' => 'Promo item title',
            'component' => [
                'heading' => 'Content column with heading',
                'filename' => 'content-column',
            ]
        ]);
         */

        $promos['video-row'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Video row',
                'filename' => 'video-row',
            ]
        ]);

        $promos['video-column'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Video column',
                'filename' => 'video-column',
            ]
        ]);

        //$promos['spotlight-1'] = app(GenericPromo::class)->create(3, false);

        $promos['steps-column'] = app(GenericPromo::class)->create(4, false, [
            'component' => [
                'heading' => 'Steps column',
                'filename' => 'steps-column',
            ]
        ]);

        return $promos;
    }
}
