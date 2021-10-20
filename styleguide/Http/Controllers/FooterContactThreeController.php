<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\FooterContact;
use Illuminate\Http\Request;

class FooterContactThreeController extends Controller
{
    /**
     * Display three column footer view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->data['contact'] = app(FooterContact::class)->create(3);

        return view('styleguide-childpage', merge($request->data));
    }
}
