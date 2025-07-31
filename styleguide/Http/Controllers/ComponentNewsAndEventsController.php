<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Event;
use Factories\ArticleComponent;
use Factories\ArticleMeta;

class ComponentNewsAndEventsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker = $faker->create();
        $this->components = $components;
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>News and events in one component.</p>
            ';
        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '
<p>Supplying IDs is optional.</p>
<p>Custom heading text <strong>is not</strong> available.</p>
<p>HeadingClass and headingLevel are available.
                        ',
                        'tr1' => [
                            'Page field' => 'modular-news-and-events-1',
                            'Data' => '{}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-news-and-events-1',
                            'Data' => '{
"news_id":0,
"events_id":0000,
"headingClass":"uppercase",
"headingLevel":"h4"
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'news-and-events-row' => [
                'data' => [
                    'news' => app(ArticleComponent::class)->create(5, false),
                    'events' => app(Event::class)->create(4, false),
                ],
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'filename' => 'news-and-events-row',
                    'cal_name' => '#'
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
