<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
use Factories\Spotlight;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {

        if(!empty($events)) {
            $events = array_values($events);

            foreach($events as $key => $event) {
                $events[$key]['component'] = [
                    'heading' => 'Events',
                    'filename' => 'events-column',
                ];
            }

            $components['components']['events-column'] = $events;
        }
        /* End events */

        $components['components']['content-row-1'] = app(GenericPromo::class)->create(2, false, [
            'title' => 'Promo item title (h3)',
            'component' => [
                'heading' => 'Content row - with heading',
                'filename' => 'content-row'
            ]
        ]);

        $components['components']['content-row-2'] = app(GenericPromo::class)->create(2, false, [
            'title' => 'Promo item title (content row - no heading)',
            'component' => [
                'filename' => 'content-row',
            ]
        ]);

        $components['components']['catalog-1'] = app(GenericPromo::class)->create(3, false, [
            'description' => '',
            'component' => [
                'heading' => 'Catalog with three columns',
                'columns' => 3,
                'filename' => 'catalog',
                'showExcerpt' => true,
                'singlePromoView' => true,
            ]
        ]);

        $components['components']['catalog-2'] = app(GenericPromo::class)->create(4, false, [
            'description' => '',
            'component' => [
                'heading' => 'Catalog with four columns',
                'columns' => 4,
                'filename' => 'catalog',
                'showExcerpt' => true,
                'singlePromoView' => true,
            ]
        ]);

        $components['components']['catalog-3'] = app(GenericPromo::class)->create(2, false, [
            'excerpt' => '',
            'component' => [
                'heading' => 'Catalog with one column',
                'columns' => '1',
                'filename' => 'catalog',
                'showExcerpt' => false,
                'singlePromoView' => true,
            ]
        ]);

        $components['components']['accordion-1'] = app(GenericPromo::class)->create(3, false, [
            'component' => [
                'heading' => 'Accordion 1',
                'filename' => 'accordion',
            ]
        ]);

        $components['components']['accordion-2'] = app(GenericPromo::class)->create(4, false, [
            'component' => [
                'heading' => 'Accordion 2',
                'filename' => 'accordion',
            ]
        ]);

        $components['components']['spotlight-1'] = app(Spotlight::class)->create(1, false, [
            'component' => [
                'heading' => 'Spotlights',
                'filename' => 'spotlight',
                'singlePromoView' => true,
            ]
        ]);

        $components['components']['button-column'] = app(GenericPromo::class)->create(3, false, [
            'component' => [
                'heading' => 'Button column',
                'filename' => 'button-column'
            ]
        ]);

        $components['components']['image-column'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Image column',
                'filename' => 'image-column'
            ]
        ]);

        $components['components']['video-row'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Video row',
                'filename' => 'video-row',
            ]
        ]);

        $components['components']['video-column'] = app(GenericPromo::class)->create(1, false, [
            'component' => [
                'heading' => 'Video column',
                'filename' => 'video-column',
            ]
        ]);

        $components['components']['icons-column'] = app(GenericPromo::class)->create(4, false, [
            'component' => [
                'heading' => 'Icons column',
                'filename' => 'icons-column',
            ]
        ]);

        dump($components);
        return $components;
    }
}
