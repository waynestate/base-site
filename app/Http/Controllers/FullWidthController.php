<?php

/*
* Status: Public
* Description: Full Width Template
* Default: true
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class FullWidthController extends Controller
{
    /**
     * Display the childpage view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['show_site_menu'] = false;

        return view('childpage', merge($request->data));
    }
}
