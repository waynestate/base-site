<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;
use Factories\GenericPromo;
use Factories\Video;

class PromoColumn extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPageController',
                'title' => 'Promo column',
                'id' => 116100,
                'content' => [
                    'main' => '<p>Single promo item with image or video that takes up one column and is full width on small views.</p>',
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
            <pre class="w-full">modular-promo-column-1</pre>
        </div>
        <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{
"id":1234,
"heading":"My heading",
"config":"randomize|limit:1|page_id",
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
                'promo-column-1' => [
                    'data' => app(GenericPromo::class)->create(1, false, [
                        'excerpt' => '',
                        'description' => '<p>' . $this->faker->text(100) . '</p>',
                    ]),
                    'component' => [
                        'heading' => 'My image',
                        'filename' => 'promo-column',
                    ],
                ],
                'promo-column-2' => [
                    'data' => app(Video::class)->create(1, false, [
                        'excerpt' => '',
                        'description' => '<p>' . $this->faker->text(100) . '</p>',
                    ]),
                    'component' => [
                        'heading' => 'My video',
                        'filename' => 'promo-column',
                    ],
                ],
            ],
        ]);
    }
}
