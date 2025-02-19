<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;
use Faker\Factory;

class FullWidthController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Display the full width template.
     */
    public function index(Request $request): View
    {
        // TODO move to layout config
        $request->data['base']['show_site_menu'] = false;
        $heroClass['heroClass'] = 'full-width-styleguide-hero';

        dump('modular controller');

        return view('childpage', merge($request->data, $heroClass));
    }
}
