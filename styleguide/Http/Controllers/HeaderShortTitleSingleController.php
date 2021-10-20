<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class HeaderShortTitleSingleController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display single header view with a custom short title
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        config([
            'base.surtitle' => null,
            'base.surtitle_main_site_enabled' => false,
            'base.top_menu_enabled' => true,
        ]);

        $request->data['base']['site']['short-title'] = $this->faker->sentence(2);

        return view('styleguide-childpage', merge($request->data));
    }
}
