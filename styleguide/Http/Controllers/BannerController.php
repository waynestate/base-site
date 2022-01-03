<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display the banner at the top of the page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->data['base']['banner'] = app(Banner::class)->create(1, true);

        return view('styleguide-childpage', merge($request->data));
    }
}
