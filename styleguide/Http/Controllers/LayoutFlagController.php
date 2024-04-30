<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\Flag;
use Illuminate\Http\Request;

class FlagController extends Controller
{
    /**
     * Display the flag at the top of the page.
     */
    public function index(Request $request): View
    {
        $request->data['base']['flag'] = app(Flag::class)->create(1, true);

        return view('styleguide-childpage', merge($request->data));
    }
}
