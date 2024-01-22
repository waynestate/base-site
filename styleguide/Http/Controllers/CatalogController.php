<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;
use Factories\PromoWithOptions;
use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;

class CatalogController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        Factory $faker,
        PromoRepositoryContract $promo,
        ModularPageRepositoryContract $components
    ) {
        $this->promo = $promo;
        $this->components = $components;
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<ul>
    <li><strong>Purpose:</strong> The catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid or single-column list format.</li>
    <li><strong>Visual presentation:</strong> Display items such as program highlights, courses, or any categorized content in a grid or list layout. The grid can feature thumbnail images with brief descriptions, while the list format might include more detailed information per item.</li>
    <li><strong>Customization:</strong> Tailor the catalog\'s appearance to suit your needs by adjusting the number of columns and items displayed per row.</li>
    <li><strong>Linking and detail views:</strong> Enable users to click on individual items within the catalog to access detailed information about each item. This might include a dedicated page for a specific catalog item providing comprehensive details, images, and a call-to-action for further engagement.
</ul>
<h2>Use cases</h2>
<ul>
    <li><strong>Program highlights:</strong> Feature unique aspects of programs, such as lab experiences, hands-on projects, cutting-edge industry equipment, or collaborations with industry partners. Each catalog item can include a description highlighting these program-specific highlights, giving insight into the program\'s strengths and distinguishing features.</li>
    <li><strong>Course listings:</strong> Display courses available within a program, department, or semester, allowing students to explore offerings and find detailed information about each course.</li>
    <li><strong>Service offerings:</strong> Showcase different services provided by the university, allowing users to explore and access detailed information about each service.</li>
    <li><strong>Student success stories:</strong> Showcase successful projects, research, or initiatives undertaken by students within different programs.</li>
</ul>
';
        $component_configuration = '
<table>
    <thead>
        <tr>
            <th>Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <pre class="w-full">modular-catalog-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Catalog",
"config":"randomize|limit:1|page_id|youtube",
"columns":3,
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
"groupByOptions":false,
"gradientOverlay":false,
"imageSize":small
}
</pre>
            </td>
        </tr>
    </tbody>
</table>
';
        $promotion_group_details = '
<table class="mt-2">
    <thead>
        <tr>
            <th colspan="2">Available fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="font-bold">Title</td>
            <td>Bold text.</td>
        </tr>
        <tr>
            <td class="font-bold">Link</td>
            <td>Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.</td>
        </tr>
        <tr>
            <td class="font-bold">Excerpt</td>
            <td>Optional smaller text under the title.</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the catalog component.</td>
        </tr>
        <tr>
            <td class="font-bold">Primary image</td>
            <td>Minimum width of 600px jpg, png.</td>
        </tr>
    </tbody>
</table>
';

        $components['components'] = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'componentConfiguration',
                        'description' => $component_configuration,
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promotionGroupDetails',
                        'description' => $promotion_group_details,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'catalog-1' => [
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
            'catalog-9' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Two-column catalog',
                    'filename' => 'catalog',
                    'columns' => '2',
                    'showDescription' => false,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'One-column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],
            'catalog-3' => [
                'data' => app(PromoWithOptions::class)->create(8, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog sorted by option',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => true,
                    'groupByOptions' => true,
                ],
            ],
            'catalog-5' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '/styleguide/image/450x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog with gradient overlay',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
            'catalog-6' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '',
                    'excerpt' => '',
                    'youtube_id' => '',
                    'link' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog without images',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => true,
                ],
            ],
        ];

        $components['components']['catalog-3']['data'] = $this->components->organizePromoItemsByOption($components['components']['catalog-3']['data']);

        return view('childpage', merge($request->data, $components));
    }
}
