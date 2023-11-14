<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;
use Factories\HeroImage;

class HeroFullRotate extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        config([
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['ModularPageController'],
        ]);

        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPageController',
                'title' => 'Rotate',
                'id' => 105100104,
                'content' => [
                    'main' => '
                        <h2>Promo group setup</h2>
                        <ul>
                            <li><strong>Primary image:</strong> Background image</li>
                            <li><strong>Title:</strong> Brief title </li>
                            <li><strong>Description:</strong> Paragraph text with inline links</li>
                            <li><strong>Option:</strong> Text Overlay</li>
                        </ul>
                        ',
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
            <pre class="w-full">modular-hero-1</pre>
        </div>
        <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{
"id":0000,
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
                'hero-1' => [
                    'data' => app(HeroImage::class)->create(4, false),
                ],
            ],
        ]);
    }
}
