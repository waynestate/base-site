<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroContainedTextController extends Controller
{
    /**
     * Display the full width hero view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Set this controller in the allowed controllers list
        config([
            'base.hero_text_enabled' => true,
            'base.hero_text_controllers' => ['HeroContainedTextController'],
        ]);

        // Remove the link from hero images
        $request->data['hero'] = collect($request->data['hero'])
            ->transform(function ($item) {
                $item['link'] = '';

                return $item;
            })
            ->toArray();

        return view('styleguide-childpage', merge($request->data));
    }
}
