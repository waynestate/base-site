<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display an example Video.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $promos['video'] = app(Video::class)->create(1, true);

        return view('styleguide-video', merge($request->data, $promos));
    }
}
