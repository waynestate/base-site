<?php

namespace Styleguide\Http\Controllers;

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
    public function index(Request $request)
    {
        $request->data['show_site_menu'] = false;

        config([
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullController'],
        ]);

        return view('styleguide-childpage', merge($request->data));
    }
}
