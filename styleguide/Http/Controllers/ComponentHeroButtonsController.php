<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Contracts\Repositories\HeroRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Button;

class ComponentHeroButtonsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components,
        HeroRepositoryContract $hero
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
        $this->hero = $hero;
    }

    /**
     * Hero Controller
     */
    public function index(Request $request): View
    {
        // Large hero buttons page
        $isLarge = $request->data['base']['page']['id'] === 105100115;

        $promos['components'] = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'component_config',
                        'description' => $isLarge
                            ? '<p>Add <code>"buttonSize":"large"</code> to increase the button padding.</p>'
                            : '<p>Optional: add <code>"buttonSize":"large"</code> to increase the button padding.</p>',
                        'tr1' => [
                            'Page field' => 'modular-hero-buttons-1',
                            'Data' => '{
"id":0000,
"option":"Gold gradient",
"config":"limit:3"'.($isLarge ? ',
"buttonSize":"large"' : '').'
}

Note: Setting the option from the config overrides all
chosen dropdown options for all buttons.',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-hero-1',
                            'Data' => '{
"id":0000,
"option":"large full",
"config":"limit:1"
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Button text',
                            'Link' => 'URL',
                            'Options' => 'Default, Green, Gold, Green gradient, Gold gradient',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'hero-buttons' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'Gold gradient',
                ]),
                'component' => array_filter([
                    'option' => 'Gold gradient',
                    'buttonSize' => $isLarge ? 'large' : null,
                ]),
            ],
        ];

        $components = $this->components->componentClasses($promos['components']);
        $components = $this->components->componentStyles($promos['components']);
        $promos = $this->hero->setHero($promos, $request->data['base']);

        // Assign components globally
        $request->data['base']['components'] = $promos['components'];
        $request->data['base']['hero_buttons'] = $promos['hero_buttons'];

        return view('childpage', merge($request->data));
    }
}
