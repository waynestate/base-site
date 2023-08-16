<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroFullController extends Controller
{
    /**
     * Display the full width hero view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        config([
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullController'],
        ]);

        return view('styleguide-childpage', merge($request->data));
    }
}
