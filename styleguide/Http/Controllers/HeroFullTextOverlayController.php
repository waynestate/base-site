<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class HeroFullTextOverlayController extends Controller
{
    /**
     * Construct the factory.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

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
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullTextOverlayController'],
        ]);

        // Set option
        $request->data['base']['hero'] = collect($request->data['base']['hero'])->map(function ($item) {
            $item['option'] = "Text Overlay";
            $item['description'] = '<p>' . ucfirst(implode(' ', $this->faker->words(10))) . ' <a href="https://wayne.edu">' . $this->faker->word() . '</a>.</p>';

            return $item;
        })->toArray();

        return view('styleguide-childpage', merge($request->data));
    }
}
