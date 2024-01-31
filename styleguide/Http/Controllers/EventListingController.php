<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Event;
use Factories\EventFullListing;

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
        $request->data['base']['page']['content']['main'] = '
<p>Adding events from the events calendar. Featured event components display images uploaded to each event.</p>
            ';
        $components['components'] = [
            'accordion-1' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'componentConfiguration',
                        'title' => 'Component configuration',
                        'description' => '
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
                <pre class="w-full">modular-events-column-1</pre>
                <pre class="w-full">modular-events-featured-column-1</pre>
                <pre class="w-full">modular-events-row-1</pre>
                <pre class="w-full">modular-events-featured-row-1</pre>
            </td>
            <td>
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
            'events-column-1' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events column',
                    'filename' => 'events-column',
                    'cal_name' => '#'
                ],
            ],
            'events-featured-column-1' => [
                'data' => app(EventFullListing::class)->create(3, false),
                'component' => [
                    'heading' => 'Featured events column',
                    'filename' => 'events-featured-column',
                    'cal_name' => '#'
                ],
            ],
            'events-row-1' => [
                'data' => app(EventFullListing::class)->create(4, false),
                'component' => [
                    'heading' => 'Events row',
                    'filename' => 'events-row',
                    'columns' => 2,
                    'cal_name' => '#'
                ],
            ],
            'events-featured-row-1' => [
                'data' => app(EventFullListing::class)->create(4, false),
                'component' => [
                    'heading' => 'Featured events row',
                    'filename' => 'events-featured-row',
                    'columns' => 4,
                    'cal_name' => '#'
                ],
            ],
        ];

        return view('childpage', merge($request->data, $components));
    }
}
