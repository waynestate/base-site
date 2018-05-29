<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FullWidthController extends Controller
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
            'base.full_width_controllers' => ['FullWidthController'],
            'base.top_menu_enabled' => true,
        ]);

        // Center the page heading
        $class['pageTitleClass'] = 'row px-4';

        return view('styleguide-childpage', merge($request->data, $class));
    }
}
