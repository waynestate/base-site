<?php
/*
* Status: Private
* Description: Full width Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class FullWidthController extends Controller
{
    /**
     * Display the homepage view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['show_site_menu'] = false;

        return view('childpage', merge($request->data));
    }
}
