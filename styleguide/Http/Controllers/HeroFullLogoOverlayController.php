<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class HeroFullLogoOverlayController extends Controller
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display the full width hero view.
     */
    public function index(Request $request): View
    {
        // Set this controller in the allowed controllers list
        config([
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroFullLogoOverlayController'],
        ]);

        // Set option
        $request->data['base']['hero'] = collect($request->data['base']['hero'])->map(function ($item) {
            $item['option'] = "Logo Overlay";
            $item['description'] = '<p>' . $this->faker->text(100) . '</p><p><a href="https://wayne.edu" class="button">Button</a></p>';
            $item['secondary_relative_url'] = '/styleguide/image/600x250?text=600x250';

            return $item;
        })->toArray();

        return view('styleguide-childpage', merge($request->data));
    }
}
