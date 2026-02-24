<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Contracts\Repositories\MenuRepositoryContract;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutHeaderTitleDoubleController extends Controller
{
    /**
     * Construct the controller.
     * @param MenuRepositoryContract $menu
     */
    public function __construct(
        Factory $faker,
        MenuRepositoryContract $menu
    )
    {
        $this->faker = $faker->create();
        $this->menu = $menu;
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
            'base.surtitle_url' => '/', 
        ]);

        //$request->data['base']['hasSurtitle'] = true;

        $request->data['base']['site']['short-title'] = $this->faker->sentence(2);
        $request->data['base']['surtitle'] = $this->faker->sentence($this->faker->numberBetween(2, 4));
        $request->data['base']['surtitle_url'] = '/';
        $request->data['base']['hasSurtitle'] = true;

        return view('childpage', merge($request->data));
    }
}
