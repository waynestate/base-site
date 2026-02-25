<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Contracts\Repositories\MenuRepositoryContract;
use Faker\Factory;

class LayoutHeaderTitleDoubleController extends Controller
{
    /** @var MenuRepositoryContract */
    protected $menu;

    /**
     * Construct the controller.
     * @param MenuRepositoryContract $event
     */
    public function __construct(
        Factory $faker,
        MenuRepositoryContract $menu
    ) {
        $this->faker = $faker->create();
        $this->menu = $menu;
    }

    /**
     * Display double title header view
     */
    public function index(Request $request): View
    {
        config([
            'base.surtitle' => $this->faker->sentence($this->faker->numberBetween(2, 4)),
            'base.surtitle_url' => '/',
            'base.surtitle_main_site_enabled' => true,
            'base.top_menu_enabled' => true,
        ]);

        $request->data['base'] = array_merge($request->data['base'], $this->menu->getSurtitle($request->data['base']['site']));

        return view('childpage', merge($request->data));
    }
}
