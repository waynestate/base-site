<?php
/*
* Status: Private
* Description: Wild Card Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WildCardController extends Controller
{
    /**
     * Display the view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return app($request->controller)->index($request);
    }
}
