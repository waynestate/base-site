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
        // Set this controller in the allowed controllers list
        config([
            'app.hero_text_enabled' => true,
            'app.hero_text_controllers' => ['HeroFullTextLinkController'],
            'app.hero_contained' => false,
        ]);

        $request->data['show_site_menu'] = false;

        return view('styleguide-childpage', merge($request->data));
    }
}
