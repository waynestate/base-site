<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Article;

class ComponentArticleListingController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $components = [
            'accordion-1' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 0,
                        'title' => 'Configuration',
                        'description' => '
<table class="no-stripe">
    <thead>
        <tr>
            <th class="md:w-2/5">Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
<pre class="w-full">modular-news-column-1</pre>
<pre class="w-full">modular-news-featured-column-1</pre>
<pre class="w-full">modular-news-row-1</pre>
            </td>
            <td>
Use default settings

<pre class="w-full" tabindex="0">
{}
</pre>

Use default calendar by omitting ID and set other configuration items

<pre class="w-full" tabindex="0">
{
"heading": "News"
}
</pre>

All available configurations
<pre class="w-full" tabindex="0">
{
"id":0,
"heading":"News",
"link_text":"More news",
"featured":true,
"limit":4,
"columns":4,
"news_route":null,
"topics":[]
}
</pre>
            </td>
        </tr>
    </tbody>
</table>',
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
            'news-column-1' => [
                'data' => app(Article::class)->create(5, false),
                'component' => [
                    'heading' => 'News column',
                    'filename' => 'news-column',
                ],
            ],
            'news-featured-column-1' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'Featured news column',
                    'filename' => 'news-featured-column',
                ],
            ],
            'news-row-1' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'News row',
                    'filename' => 'news-row',
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
