<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;
use Factories\AccordionItems;

class Accordion extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPageController',
                'title' => 'Accordion',
                'id' => 107100,
                'content' => [
                    'main' => '<p>You can now add more than one accordion to a page.</p>',
                ],
            ],
            'components' => [
                'accordion-1' => [
                    'data' => [
                        0 => [
                            'promo_item_id' => 0,
                            'title' => 'Configuration',
                            'description' => '
<p>Visit the modular documentation for more information</p>
<div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b">
        <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
        <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
        <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
            <pre class="w-full">modular-accordion-1</pre>
        </div>
        <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{
"id":1234,
"heading":"My accordion",
}
</pre>
        </div>
    </div>
',
                        ],
                    ],
                    'component' => [
                        'filename' => 'accordion',
                    ],
                ],
                'accordion-2' => [
                    'data' => app(AccordionItems::class)->create(4, false),
                    'component' => [
                        'heading' => 'My accordion',
                        'filename' => 'accordion',
                    ],
                ],
                'accordion-3' => [
                    'data' => app(AccordionItems::class)->create(3, false),
                    'component' => [
                        'heading' => 'My second accordion',
                        'filename' => 'accordion',
                    ],
                ],
            ],
        ]);
    }
}
