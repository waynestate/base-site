<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;
use Factories\GenericPromo;

class Catalog extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPageController',
                'title' => 'Catalog',
                'id' => 118100,
                'content' => [
                    'main' => '<p>Display a grid or listing of items from a single promo group.</p>',
                ],
            ],
            'components' => [
                'accordion-1' => [
                    'data' => [
                        0 => [
                            'title' => 'Configuration',
                            'description' => '
<p>Visit the modular documentation for more information</p>
<div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b">
        <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
        <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
        <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
            <pre class="w-full">modular-catalog-1</pre>
        </div>
        <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{
"id":1234,
"heading":"My heading",
"config":"randomize|limit:1|page_id|youtube",
"singlePromoView":"true",
"showExcerpt":"false",
"showDescription":"true"
}
</pre>
        </div>
    </div>
',
                            'promo_item_id' => 0,
                        ],
                    ],
                    'component' => [
                        'filename' => 'accordion',
                        'columns' => '4',
                        'showDescription' => false,
                    ],
                ],
                'catalog-1' => [
                    'data' => app(GenericPromo::class)->create(7, false, [
                        'description' => '',
                    ]),
                    'component' => [
                        'heading' => 'Four-column catalog',
                        'filename' => 'catalog',
                        'columns' => '4',
                        'showDescription' => false,
                    ],
                ],
                'catalog-2' => [
                    'data' => app(GenericPromo::class)->create(3, false, [
                        'description' => '',
                    ]),
                    'component' => [
                        'heading' => 'Three-column catalog',
                        'filename' => 'catalog',
                        'columns' => '3',
                        'showDescription' => false,
                    ],
                ],
                'catalog-3' => [
                    'data' => app(GenericPromo::class)->create(3, false, [
                        'excerpt' => '',
                    ]),
                    'component' => [
                        'heading' => 'One-column catalog',
                        'filename' => 'catalog',
                        'columns' => '1',
                        'showDescription' => false,
                    ],
                ],
            ],
        ]);
    }
}
