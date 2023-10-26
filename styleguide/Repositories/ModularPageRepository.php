<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
use Factories\Spotlight;
use Factories\Article;
use Factories\Event;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        $components = [
            'news-column-1' => [
                'data' => app(Article::class)->create(3, false),
                'component' => [
                    'heading' => 'News',
                    'filename' => 'news-column',
                ],
            ],
            'events-column-1' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events',
                    'filename' => 'events-column',
                ],
            ],
            'content-row-1' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Content row - with heading',
                    'filename' => 'content-row'
                ],
            ],
            'content-row-2' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Promo item title (content row - no heading)',
                    'filename' => 'content-row',
                ],
            ],
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog with three columns',
                    'columns' => 3,
                    'filename' => 'catalog',
                    'showExcerpt' => true,
                    'singlePromoView' => true,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog with four columns',
                    'columns' => 4,
                    'filename' => 'catalog',
                    'showExcerpt' => true,
                    'singlePromoView' => true,
                ],
            ],
            'catalog-3' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'excerpt' => '',

                ]),
                'component' => [
                    'heading' => 'Catalog with one column',
                    'columns' => '1',
                    'filename' => 'catalog',
                    'showExcerpt' => false,
                    'singlePromoView' => true,
                ],
            ],
            'accordion-1' => [
                'data' => app(GenericPromo::class)->create(3, false),
                'component' => [
                    'heading' => 'Accordion 1',
                    'filename' => 'accordion',
                ],
            ],
            'accordion-2' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'heading' => 'Accordion 2',
                    'filename' => 'accordion',
                ],
            ],
            'spotlight-1' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlights',
                    'filename' => 'spotlight',
                    'singlePromoView' => true,
                ],
            ],
            'button-column' => [
                'data' => app(GenericPromo::class)->create(3, false),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column'
                ],
            ],
            'image-column' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Image column',
                    'filename' => 'image-column'
                ],
            ],
            'video-row' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video row',
                    'filename' => 'video-row',
                ],
            ],
            'video-column' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column',
                    'filename' => 'video-column',
                ],
            ],
            'steps-column' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'heading' => 'Steps column',
                    'filename' => 'steps-column',
                ],
            ],
        ];

        return $components;
    }
}
