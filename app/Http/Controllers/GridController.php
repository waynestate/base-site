<?php
/*
* Status: Public
* Description: Grid Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChildpageController extends Controller
{
    /**
     * Display the childpage view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('childpage', merge($request->data));
    }
}
