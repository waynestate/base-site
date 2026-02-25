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
     * Display double title header view
     */
    public function index(Request $request): View
    {
        config([
            'base.top_menu_enabled' => true,
        ]);

        $request->data['base']['surtitle'] = $this->faker->sentence($this->faker->numberBetween(2, 4));
        $request->data['base']['surtitle_url'] = '/';
        $request->data['base']['hasSurtitle'] = true;

        return view('childpage', merge($request->data));
    }
}
