<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Icon;
use Factories\Button;
use Factories\GenericPromo;
use Factories\ArticleMeta;
use Factories\ArticleComponent;
use Factories\Event;
use Factories\EmptyPromo;

class TemplateGuideController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Display the full width hero view.
     */
    public function index(Request $request): View
    {
        $components = [
            // ------------------------------------
            // Column span
            // ------------------------------------
            'promo-row-1000' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Customizing columns',
                    'description' => '
                        <p>Column widths can span from 1 to 12 available columns.</p>
                        <p>Specify the width of a component by using <code>"columnSpan": <em>n</em></code>.</p>
                        <p>You must use the "end" class on the last component in a row, <code>"sectionClass": "end"</code>.</p>
                    ',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Row 1
            'promo-column-1011' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '1',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 1,
                ],
            ],

            'promo-column-1012' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '11',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 11,
                ],
            ],

            // Row 2
            'promo-column-1021' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '2',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 2,
                ],
            ],

            'promo-column-1022' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '10',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 10,
                ],
            ],

            // Row 3
            'promo-column-1031' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '3',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center',
                    'columnSpan' => 3,
                ],
            ],

            'promo-column-1032' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '9',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 9,
                ],
            ],

            // Row 4
            'promo-column-1041' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '4',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 4,
                ],
            ],

            'promo-column-1042' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '8',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 8,
                ],
            ],

            // Row 5
            'promo-column-1051' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '5',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 5,
                ],
            ],

            'promo-column-1052' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '7',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 7,
                ],
            ],

            // Row 6
            'promo-column-1061' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '6',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 6,
                ],
            ],

            'promo-column-1062' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => '6',
                ]),
                'component' => [
                    'filename' => 'promo-column',
                    'classes' => 'col-bg rounded-sm bg-gold-50 p-2 pt-1 text-center overflow-hidden',
                    'columnSpan' => 6,
                ],
            ],

            // ------------------------------------
            // Two unequal columns
            // ------------------------------------
            'promo-row-200' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Two unequal columns',
                    'description' => '',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Two unequal columns - Configuration accordion
            'accordion-201' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-two-col',
                        'title' => 'Two unequal columns configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-catalog',
                            'Data' => '{
"id": 0,
"columnSpan": 8,
"columns": 1,
"showDescription": false,
"imageSize": "small",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-column',
                            'Data' => '{
"id": 0,
"columnSpan": 4,
"classes": "end",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Two unequal columns - Catalog
            'catalog-202' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Column one',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                    'imageSize' => 'small',
                    'columnSpan' => 8,
                    'classes' => 'col-bg rounded-sm bg-gold-50 py-2 overflow-hidden',
                ],
            ],

            // Two unequal columns - Buttons
            'button-column-203' => [
                'data' => app(Button::class)->create(4, false, [
                    'option' => 'Default',
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Column 2',
                    'filename' => 'button-column',
                    'columnSpan' => 4,
                    'classes' => 'col-bg rounded-sm bg-gold-50 py-2 end overflow-hidden',
                ],
            ],


            // ------------------------------------
            // Two equal columns
            // ------------------------------------
            'promo-row-301' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Two equal columns',
                    'description' => '',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Two equal columns - Configuration accordion
            'accordion-302' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-two-col',
                        'title' => 'Two equal columns configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-news-column',
                            'Data' => '{
"id":0,
"columnSpan": 6,
"heading":"News",
"link_text":"More news",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-events-column',
                            'Data' => '{
"id": 0,
"columnSpan": 6,
"classes": "end",
"cal_name": "myurl/",
"link_text":"More events"
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Two equal columns - News
            'news-column-303' => [
                'data' => app(ArticleComponent::class)->create(4, false),
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'heading' => 'News',
                    'filename' => 'news-column',
                    'columnSpan' => 6,
                    'classes' => 'col-bg rounded-sm bg-gold-50 py-2 overflow-hidden',
                ],
            ],

            // Two equal columns - Events
            'events-column-304' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events',
                    'filename' => 'events-column',
                    'columnSpan' => 6,
                    'classes' => 'col-bg rounded-sm bg-gold-50 py-2 end overflow-hidden',
                    'cal_name' => 'main/',
                    'link_text' => 'More events',
                ],
            ],


            // ------------------------------------
            // Narrow column
            // ------------------------------------
            'promo-row-400' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Centered narrow column',
                    'description' => '',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Narrow column - Config accordion
            'accordion-401' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-narrow-column',
                        'title' => 'Centered narrow column configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-promo-row',
                            'Data' => '{
"id": 0,
"columnSpan": 10,
"classes": "end bg-gold-50 rounded-sm px-gutter pb-gutte overflow-hiddenr",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Narrow column - Example
            'promo-row-402' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                        'description' => '<p>' . $this->faker['faker']->text(1500) . '</p><p>' . $this->faker['faker']->text(1500) . '</p>',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                    'columnSpan' => 10,
                    'classes' => 'end bg-gold-50 rounded-sm px-gutter pb-gutter overflow-hidden',
                ],
            ],

            // ------------------------------------
            // Offset column
            // ------------------------------------
            'promo-row-900' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Offset column',
                    'description' => '<p>Individual columns in their own row are centered by default.
To align columns to the left or right of the content area, apply a class to shift the component by <span class="italic">n</span> number of columns.
Use <code>mt:left-span-3</code> to move a component 3 columns from the left.
Use <code>mt:right-span-3</code> to move a component 3 columns from the right.
Span values range from 1 to 12. It is important to include the <code>mt:</code> prefix, otherwise the component may be missing from mobile view.
</p>',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Offset column - Config accordion
            'accordion-901' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-offset-column',
                        'title' => 'Offset column configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-events-column',
                            'Data' => '{
"id": 0,
"columnSpan": 6,
"classes": "end mt:right-span-3",
"cal_name": "myurl/",
"link_text":"More events"
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Offset column - Events
            'events-column-904' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events',
                    'filename' => 'events-column',
                    'columnSpan' => 6,
                    'classes' => 'bg-gold-50 rounded-sm py-2 end mt:right-span-3 overflow-hidden',
                    'cal_name' => 'main/',
                    'link_text' => 'More events',
                ],
            ],

            // ------------------------------------
            // Background image - Button row
            // ------------------------------------
            'promo-row-999' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Component background image',
                    'description' => '',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Background image - Config accordion
            'accordion-1001' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-background-image',
                        'title' => 'Background image component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-button-row',
                            'Data' => json_encode([
                                'id' => 0,
                                'backgroundImageUrl' => Vite::asset('resources/images/background.svg'),
                                'classes' => 'py-gutter-lg px-gutter-lg rounded-sm text-white overflow-hidden',
                            ]),
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Background image - Button row
            'button-row-1002' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'filename' => 'button-row',
                    'backgroundImageUrl' => Vite::asset('resources/images/background.svg'),
                    'classes' => 'py-gutter-lg px-gutter-lg text-white rounded-sm overflow-hidden',
                    'sectionStyle' => 'background-size:350px;',
                ],
            ],


            // ------------------------------------
            // Row pairs
            // ------------------------------------
            'promo-row-500' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Row pairs',
                    'description' => '<p>Two separate component rows with adjustments to appear as one component.</p>',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],

            // Row pairs - Config accordion
            'accordion-501' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-row-pairs',
                        'title' => 'Row pairs configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-icons-top-row',
                            'Data' => '{
"id": 0,
"heading": "Facts",
"columns": 4,
"classes": "bg-gold-50 px-gutter pt-gutter",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-row',
                            'Data' => '{
"id": 0,
"columns": 1,
"classes": "bg-gold-50 p-gutter -mt-gutter",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter'
                ],
            ],

            // Row pairs - Icons
            'icons-row-502' => [
                'data' => app(Icon::class)->create(4, false, [
                    'link' => '',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Icons',
                    'filename' => 'icons-top-row',
                    'columns' => 4,
                    'classes' => 'bg-gold-50 px-gutter pt-gutter'
                ],
            ],

            // Row pairs - Button
            'button-row-503' => [
                'data' => app(Button::class)->create(1, false, [
                    'title' => 'Get more facts',
                    'option' => 'Green gradient',
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'button-row',
                    'columns' => 1,
                    'classes' => 'bg-gold-50 p-gutter -mt-gutter-md'
                ],
            ],

            // ------------------------------------
            // Gutters
            // ------------------------------------
            'promo-row-600' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Customizing gutters',
                    'description' => '
<p>Control the component\'s padding or margin using the gutter class.
Replace the askterisk <code>*</code> in the gutter class with your margin or padding property.
Padding is used in the example below, however use <code>m</code> for margin instead of <code>p</code> if desired.
</p>

<h3>Example:</h3>
<table class="mt-2">
    <thead>
        <tr>
            <th>Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><pre class="w-full">modular-promo-column</pre></td>
            <td>
<pre class="w-full" tabindex="0">
"id":0,
"classes":"py-gutter-lg mb-gutter-xl"
</pre>
            </td>
        </tr>
    </tbody>
</table>

<h3>Reference</h3>
<div class="two-col-layout">
<div class="w-full">
<table>
    <thead>
        <th>Class</th>
        <th>Properties</th>
    </thead>
    <tbody>
        <tr>
            <td><code>*-gutter-xs</code></td>
            <td>0.5 rem</td>
        </tr>
        <tr>
            <td><code>*-gutter-sm</code></td>
            <td>1 rem</td>
        </tr>
        <tr>
            <td><code>*-gutter</code></td>
            <td>2 rem</td>
        </tr>
        <tr>
            <td><code>*-gutter-md</code></td>
            <td>3 rem</td>
        </tr>
        <tr>
            <td><code>*-gutter-lg</code></td>
            <td>4 rem</td>
        </tr>
        <tr>
            <td><code>*-gutter-xl</code></td>
            <td>5 rem</td>
        </tr>
    </tbody>
</table>
</div>
<div class="w-full">
<table>
    <thead>
        <th>Class</th>
        <th>Properties</th>
    </thead>
    <tr>
        <td><code>px</code></td>
        <td>Left and right padding</td>
    </tr>
    <tr>
        <td><code>py</code></td>
        <td>Top and bottom padding</td>
    </tr>
    <tr>
        <td><code>pt</code></td>
        <td>Top padding</td>
    </tr>
    <tr>
        <td><code>pr</code></td>
        <td>Right padding</td>
    </tr>
    <tr>
        <td><code>pb</code></td>
        <td>Bottom padding</td>
    </tr>
    <tr>
        <td><code>pl</code></td>
        <td>Left padding</td>
    </tr>
</table>
</div>
</div>
                    ',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                    'headingLevel' => 'h2',
                ],
            ],
        ];

        $heroClass['heroClass'] = 'full-width-styleguide-hero';

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $this->faker, $components, $heroClass));
    }
}
