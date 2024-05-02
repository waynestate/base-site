<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class CMSBasicLayoutsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display the styleguide view.
     */
    public function index(Request $request): View
    {
        return view('styleguide-cms-basic-layouts', merge($request->data, $this->faker));
    }
}
