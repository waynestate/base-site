<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class HeroFullDescriptionOverlayController extends Controller
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
            'base.hero_text_controllers' => ['HeroFullDescriptionOverlayController'],
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullDescriptionOverlayController'],
        ]);

        // Set option
        $request->data['hero'] = collect($request->data['hero'])->map(function ($item) {
            $item['option'] = "Description Overlay";
            $item['description'] = '<p>' . $this->faker->text(100) . '</p><p><a href="https://wayne.edu" class="button">Button</a></p>';
            $item['secondary_relative_url'] = '/styleguide/image/600x250?text=600x250';

            return $item;
        })->toArray();

        return view('styleguide-childpage', merge($request->data));
    }
}
