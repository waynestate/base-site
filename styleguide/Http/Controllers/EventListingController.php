<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Event;

class EventListingController extends Controller
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
        $components['components'] = [
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
        <pre class="w-full">modular-events-column-1</pre>
        <pre class="w-full">modular-events-row-1</pre>
    </div>
    <div class="lg:col-span-2 p-2 order-4 lg:order-none">
Use default settings
<pre class="w-full" tabindex="0">
{}
</pre>
Use default calendar by omitting ID and set other configuration items
<pre class="w-full" tabindex="0">
{
"heading": "My events"
}
</pre>
All available configurations
<pre class="w-full" tabindex="0">
{
"id":null,
"heading":"Events",
"config":"limit:4",
"cal_name": "myurl/",
"link_text":"More events"
}
</pre></div></div>',
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
            'events-column-1' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'My events',
                    'filename' => 'events-column',
                ],
            ],
            'events-row-1' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'My event row',
                    'filename' => 'events-row',
                ],
            ],
        ];

        return view('modularpage', merge($request->data, $components));
    }
}
