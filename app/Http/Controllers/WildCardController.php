<?php
/*
* Status: Private
* Description: Wild Card Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class WildCardController extends Controller
{
    /**
     * Display the view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        return app($request->controller)->index($request);
    }
}
