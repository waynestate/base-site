<?php
/*
* Status: Public
* Description: Topic Listing Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display the topic listing view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('topics', merge($request->data));
    }
}
