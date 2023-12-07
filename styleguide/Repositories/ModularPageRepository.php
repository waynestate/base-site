<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
use Factories\Button;
use Factories\Spotlight;
use Factories\Article;
use Factories\Event;
use Factories\HeroImage;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        $components = [
            'hero-1' => [
                'data' => app(HeroImage::class)->create(1, false),
                'component' => [
                    'filename' => 'hero',
                ],
            ],
            'button-row' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'green',
                    'excerpt' => '',
                    'relative_url' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==',
                    'filename_alt_text' => '',
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                ],
            ],
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Four column catalog',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],

            'content-row-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Content row',
                    'description' => '<p>Example placement of an introductory paragraph describing the information laid out in the accordion below.</p><p>This is a separate promo group using the "content row" component. Below this is a different promo group with the accordion data and no component heading specified.</p>',
                ]),
                'component' => [
                    'filename' => 'content-row',
                ],
            ],

            'accordion-1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                ],
            ],

            'image-column-1'=> [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured news (image column)',
                    'filename_url' => '/styleguide/image/770x434',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'news-column' => [
                'data' => app(Article::class)->create(3, false),
                'component' => [
                    'heading' => 'Base news',
                    'filename' => 'news-column',
                ],
            ],

            'events-column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Base events',
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl'
                ],
            ],

            'image-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (image column)',
                    'filename_url' => '/styleguide/image/600x600',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                ]),
                'component' => [
                    'heading' => 'Single column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],

            'spotlight' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                ],
            ],

            'video-row' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video row',
                    'filename' => 'video-row',
                ],
            ],

            'video-column-1' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column',
                    'filename' => 'video-column',
                ],
            ],

            'button-column' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'option' => 'Default',
                    'excerpt' => '',
                    'relative_url' => '',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],
        ];

        return $components;
    }
}
