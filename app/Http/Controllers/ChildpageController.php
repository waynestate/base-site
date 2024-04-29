<?php
/*
* Status: Public
* Description: Childpage Template
* Default: true
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class ChildpageController extends Controller
{
    /**
     * Display the childpage view.
     */
    public function index(Request $request): View
    {
        return view('childpage', merge($request->data));
    }
}
