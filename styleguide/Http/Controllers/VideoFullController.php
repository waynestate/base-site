<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoFullController extends Controller
{
    /**
     * Display an example Video Full width.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['video_full'] = app('Factories\VideoFull')->create(1, true);

        $request->data['show_site_menu'] = false;

        config([
            'base.full_width_controllers' => ['VideoFullController'],
        ]);

        return view('styleguide-video-full', merge($request->data, $promos));
    }
}
