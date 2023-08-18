<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\FooterContact;
use Illuminate\Http\Request;

class FooterContactThreeController extends Controller
{
    /**
     * Display three column footer view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['contact'] = app(FooterContact::class)->create(3);

        return view('styleguide-childpage', merge($request->data));
    }
}
