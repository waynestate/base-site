<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutHeaderTitleDoubleController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display the double header view with a custom short title
     */
    public function index(Request $request): View
    {
        config([
            'base.surtitle' => $this->faker->sentence($this->faker->numberBetween(2, 4)),
            'base.surtitle_main_site_enabled' => true,
            'base.top_menu_enabled' => true,
        ]);

        $request->data['base']['site']['short-title'] = $this->faker->sentence(2);

        return view('styleguide-childpage', merge($request->data));
    }
}
