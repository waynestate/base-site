<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class FullWidthController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display the full width hero view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['show_site_menu'] = false;

        config([
            'base.full_width_controllers' => ['FullWidthController'],
            'base.top_menu_enabled' => true,
        ]);

        // Center the page heading
        $class['pageTitleClass'] = 'row px-4';

        return view('styleguide-fullwidth', merge($request->data, $this->faker, $class));
    }
}
