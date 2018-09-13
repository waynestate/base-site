<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroFullTextLinkController extends Controller
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

        // Set this controller in the allowed controllers list
        config([
            'base.hero_text_enabled' => true,
            'base.hero_text_controllers' => ['HeroFullTextLinkController'],
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullTextLinkController'],
        ]);

        return view('styleguide-childpage', merge($request->data));
    }
}
