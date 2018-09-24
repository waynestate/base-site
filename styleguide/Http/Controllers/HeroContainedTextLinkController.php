<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroContainedTextLinkController extends Controller
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
            'base.hero_text_controllers' => ['HeroContainedTextLinkController'],
        ]);

        return view('styleguide-childpage', merge($request->data));
    }
}
