<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\UnderMenu;
use Illuminate\Http\Request;
use Faker\Factory;

class UnderMenuController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display each under menu button option.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $icon_green = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjAuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMDAgMTAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzA4MzUyRjt9Cjwvc3R5bGU+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01MCwyLjVDMjMuOCwyLjUsMi41LDIzLjgsMi41LDUwUzIzLjgsOTcuNSw1MCw5Ny41Uzk3LjUsNzYuMiw5Ny41LDUwUzc2LjIsMi41LDUwLDIuNXogTTQzLjgsMjAuOQoJYzEuNi0xLjUsMy41LTIuMiw1LjYtMi4yYzIuMiwwLDQuMSwwLjcsNS42LDIuMmMxLjYsMS41LDIuMywzLjIsMi4zLDUuM2MwLDItMC44LDMuOC0yLjQsNS4yYy0xLjYsMS40LTMuNCwyLjItNS42LDIuMgoJYy0yLjIsMC00LjEtMC43LTUuNi0yLjJjLTEuNi0xLjQtMi40LTMuMi0yLjQtNS4yQzQxLjQsMjQuMSw0Mi4yLDIyLjMsNDMuOCwyMC45eiBNNjMuMyw4MS4zSDM3Ljd2LTNjMC43LTAuMSwxLjQtMC4xLDIuMS0wLjIKCXMxLjMtMC4yLDEuNy0wLjRjMC45LTAuMywxLjUtMC44LDEuOC0xLjRzMC41LTEuNCwwLjUtMi40VjUwLjRjMC0wLjktMC4yLTEuOC0wLjYtMi41Yy0wLjQtMC43LTEtMS4zLTEuNi0xLjcKCWMtMC41LTAuMy0xLjItMC42LTIuMi0wLjlzLTEuOS0wLjUtMi43LTAuNnYtM2wxOS44LTEuMWwwLjYsMC42djMyLjFjMCwwLjksMC4yLDEuNywwLjYsMi40YzAuNCwwLjcsMSwxLjIsMS43LDEuNQoJYzAuNSwwLjIsMS4xLDAuNSwxLjgsMC42YzAuNiwwLjIsMS4zLDAuMywyLDAuNHYzLjFDNjMuMiw4MS4zLDYzLjMsODEuMyw2My4zLDgxLjN6Ii8+Cjwvc3ZnPgo=";
        $icon_white = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==";
        $svg_dark = "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMzYwIDEzMSI+PHN0eWxlPi5zdDB7ZmlsbDojZmZmfTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM0OSA4Ny40VjEwLjhIMTF2MTA5aDE2MS44djJIOVY4LjhoMzQydjc4LjZoLTJ6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTE3OS4yIDExMi41bC01LjYtMTguOWg0LjdsMy40IDEyLjloLjFsMy40LTEyLjloNC4ybC01LjYgMTguOXY5LjRoLTQuNXYtOS40em0xMC45LTEyLjJjMC00LjUgMi40LTcuMSA2LjgtNy4xczYuOCAyLjYgNi44IDcuMVYxMTVjMCA0LjUtMi40IDcuMS02LjggNy4xcy02LjgtMi42LTYuOC03LjF2LTE0Ljd6bTQuNCAxNWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS44IDIuMy0yLjhWMTAwYzAtMi0uOS0yLjgtMi4zLTIuOHMtMi4zLjgtMi4zIDIuOHYxNS4zem0xNi4yLTIxLjh2MjEuOWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS43IDIuMy0yLjhWOTMuNWg0LjJ2MjEuNmMwIDQuNS0yLjMgNy4xLTYuNiA3LjFzLTYuNi0yLjYtNi42LTcuMVY5My41aDQuNHptMjEuMiAyOC40Yy0uMi0uNy0uNC0xLjItLjQtMy41di00LjVjMC0yLjYtLjktMy42LTIuOS0zLjZIMjI3djExLjVoLTQuNVY5My41aDYuN2M0LjYgMCA2LjYgMi4xIDYuNiA2LjV2Mi4yYzAgMi45LS45IDQuOC0yLjkgNS43di4xYzIuMi45IDMgMyAzIDZ2NC40YzAgMS40IDAgMi40LjUgMy40aC00LjV6TTIyNyA5Ny42djguN2gxLjdjMS43IDAgMi43LS43IDIuNy0zdi0yLjhjMC0yLS43LTIuOS0yLjMtMi45SDIyN3ptMTcuOCAyLjdjMC00LjUgMi40LTcuMSA2LjgtNy4xczYuOCAyLjYgNi44IDcuMVYxMTVjMCA0LjUtMi40IDcuMS02LjggNy4xcy02LjgtMi42LTYuOC03LjF2LTE0Ljd6bTQuNCAxNWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS44IDIuMy0yLjhWMTAwYzAtMi0uOS0yLjgtMi4zLTIuOHMtMi4zLjgtMi4zIDIuOHYxNS4zem0xOC42IDEuM2wzLjQtMjMuMWg0LjFsLTQuNCAyOC4zaC02LjZsLTQuNC0yOC4zaDQuNWwzLjQgMjMuMXptMTQtMTEuMWg2LjF2NGgtNi4xdjguM2g3Ljd2NGgtMTIuMVY5My41aDEyLjF2NGgtNy43djh6bTE5LjggMTYuNGMtLjItLjctLjQtMS4yLS40LTMuNXYtNC41YzAtMi42LS45LTMuNi0yLjktMy42aC0xLjV2MTEuNWgtNC41VjkzLjVoNi43YzQuNiAwIDYuNiAyLjEgNi42IDYuNXYyLjJjMCAyLjktLjkgNC44LTIuOSA1Ljd2LjFjMi4yLjkgMyAzIDMgNnY0LjRjMCAxLjQgMCAyLjQuNSAzLjRoLTQuNnptLTQuOS0yNC4zdjguN2gxLjdjMS43IDAgMi43LS43IDIuNy0zdi0yLjhjMC0yLS43LTIuOS0yLjMtMi45aC0yLjF6bTExLjgtNC4xaDQuNXYyNC4zaDcuM3Y0aC0xMS44VjkzLjV6bTI4LjIgMjguNGgtNC41bC0uOC01LjFoLTUuNWwtLjggNS4xSDMyMWw0LjUtMjguM2g2LjVsNC43IDI4LjN6bS0xMC4yLTloNC4zbC0yLjEtMTQuM2gtLjFsLTIuMSAxNC4zem0xNC40LS40bC01LjYtMTguOWg0LjdsMy40IDEyLjloLjFsMy40LTEyLjloNC4ybC01LjYgMTguOXY5LjRIMzQxdi05LjR6Ii8+PC9zdmc+";
        $svg_light = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNjAgMTMxIj48cGF0aCBkPSJNMzQ5IDg3LjRWMTAuOEgxMXYxMDloMTYxLjh2Mkg5VjguOGgzNDJ2NzguNmgtMnoiLz48cGF0aCBkPSJNMTc5LjIgMTEyLjVsLTUuNi0xOC45aDQuN2wzLjQgMTIuOWguMWwzLjQtMTIuOWg0LjJsLTUuNiAxOC45djkuNGgtNC41di05LjR6bTEwLjktMTIuMmMwLTQuNSAyLjQtNy4xIDYuOC03LjFzNi44IDIuNiA2LjggNy4xVjExNWMwIDQuNS0yLjQgNy4xLTYuOCA3LjFzLTYuOC0yLjYtNi44LTcuMXYtMTQuN3ptNC40IDE1YzAgMiAuOSAyLjggMi4zIDIuOHMyLjMtLjggMi4zLTIuOFYxMDBjMC0yLS45LTIuOC0yLjMtMi44cy0yLjMuOC0yLjMgMi44djE1LjN6bTE2LjItMjEuOHYyMS45YzAgMiAuOSAyLjggMi4zIDIuOHMyLjMtLjcgMi4zLTIuOFY5My41aDQuMnYyMS42YzAgNC41LTIuMyA3LjEtNi42IDcuMXMtNi42LTIuNi02LjYtNy4xVjkzLjVoNC40em0yMS4yIDI4LjRjLS4yLS43LS40LTEuMi0uNC0zLjV2LTQuNWMwLTIuNi0uOS0zLjYtMi45LTMuNkgyMjd2MTEuNWgtNC41VjkzLjVoNi43YzQuNiAwIDYuNiAyLjEgNi42IDYuNXYyLjJjMCAyLjktLjkgNC44LTIuOSA1Ljd2LjFjMi4yLjkgMyAzIDMgNnY0LjRjMCAxLjQgMCAyLjQuNSAzLjRoLTQuNXpNMjI3IDk3LjZ2OC43aDEuN2MxLjcgMCAyLjctLjcgMi43LTN2LTIuOGMwLTItLjctMi45LTIuMy0yLjlIMjI3em0xNy44IDIuN2MwLTQuNSAyLjQtNy4xIDYuOC03LjFzNi44IDIuNiA2LjggNy4xVjExNWMwIDQuNS0yLjQgNy4xLTYuOCA3LjFzLTYuOC0yLjYtNi44LTcuMXYtMTQuN3ptNC40IDE1YzAgMiAuOSAyLjggMi4zIDIuOHMyLjMtLjggMi4zLTIuOFYxMDBjMC0yLS45LTIuOC0yLjMtMi44cy0yLjMuOC0yLjMgMi44djE1LjN6bTE4LjYgMS4zbDMuNC0yMy4xaDQuMWwtNC40IDI4LjNoLTYuNmwtNC40LTI4LjNoNC41bDMuNCAyMy4xem0xNC0xMS4xaDYuMXY0aC02LjF2OC4zaDcuN3Y0aC0xMi4xVjkzLjVoMTIuMXY0aC03Ljd2OHptMTkuOCAxNi40Yy0uMi0uNy0uNC0xLjItLjQtMy41di00LjVjMC0yLjYtLjktMy42LTIuOS0zLjZoLTEuNXYxMS41aC00LjVWOTMuNWg2LjdjNC42IDAgNi42IDIuMSA2LjYgNi41djIuMmMwIDIuOS0uOSA0LjgtMi45IDUuN3YuMWMyLjIuOSAzIDMgMyA2djQuNGMwIDEuNCAwIDIuNC41IDMuNGgtNC42em0tNC45LTI0LjN2OC43aDEuN2MxLjcgMCAyLjctLjcgMi43LTN2LTIuOGMwLTItLjctMi45LTIuMy0yLjloLTIuMXptMTEuOC00LjFoNC41djI0LjNoNy4zdjRoLTExLjhWOTMuNXptMjguMiAyOC40aC00LjVsLS44LTUuMWgtNS41bC0uOCA1LjFIMzIxbDQuNS0yOC4zaDYuNWw0LjcgMjguM3ptLTEwLjItOWg0LjNsLTIuMS0xNC4zaC0uMWwtMi4xIDE0LjN6bTE0LjQtLjRsLTUuNi0xOC45aDQuN2wzLjQgMTIuOWguMWwzLjQtMTIuOWg0LjJsLTUuNiAxOC45djkuNEgzNDF2LTkuNHoiLz48L3N2Zz4=";

        // Default button
        $promos['buttons']['default'] = app(UnderMenu::class)->create(1, true, [
            'option' => 'Default',
        ]);

        // Default two lines
        $promos['buttons']['default_two_lines'] = app(UnderMenu::class)->create(1, true, [
            'excerpt' => ucfirst(implode(' ', $this->faker->words(3))),
        ]);

        // Default icon
        $promos['buttons']['default_icon'] = app(UnderMenu::class)->create(1, true, [
            'excerpt' => ucfirst(implode(' ', $this->faker->words(3))),
            'relative_url' => $icon_green,
            'filename_alt_text' => 'Example white icon',
        ]);

        // Green button
        $promos['buttons']['green'] = app(UnderMenu::class)->create(1, true, [
            'option' => 'Green',
        ]);

        // Green two lines
        $promos['buttons']['green_two_lines'] = app(UnderMenu::class)->create(1, true, [
            'option' => 'Green',
            'excerpt' => ucfirst(implode(' ', $this->faker->words(3))),
        ]);

        // Green icon
        $promos['buttons']['green_icon'] = app(UnderMenu::class)->create(1, true, [
            'option' => 'Green',
            'secondary_relative_url' => $icon_white,
            'excerpt' => ucfirst(implode(' ', $this->faker->words(3))),
            'secondary_alt_text' => 'Example green icon',
        ]);

        // Bg image light
        $promos['buttons']['bg_image_light'] = app(UnderMenu::class)->create(1, true, [
            'title' => 'Example Text',
            'option' => 'Bg image light',
            'relative_url' => "/styleguide/image/600x218",
            'filename_alt_text' => "Bg image dark",
        ]);

        // Bg image dark
        $promos['buttons']['bg_image_dark'] = app(UnderMenu::class)->create(1, true, [
            'title' => 'Example Text',
            'option' => 'Bg image dark',
            'relative_url' => "/styleguide/image/600x218",
            'filename_alt_text' => "Bg image dark",
        ]);

        // SVG overlay bg light
        $promos['buttons']['svg_light_bg'] = app(UnderMenu::class)->create(1, true, [
            'title' => 'Example light SVG overlay',
            'option' => 'SVG light bg',
            'relative_url' => "/styleguide/image/600x218",
            'filename_alt_text' => "Bg image dark",
            'secondary_relative_url' => $svg_light,
            'secondary_alt_text' => 'Example light overlay image',
        ]);

        // SVG overlay bg dark
        $promos['buttons']['svg_dark_bg'] = app(UnderMenu::class)->create(1, true, [
            'title' => 'Example dark SVG overlay',
            'option' => 'SVG dark bg',
            'relative_url' => "/styleguide/image/600x218",
            'filename_alt_text' => "Bg image dark",
            'secondary_relative_url' => $svg_dark,
            'secondary_alt_text' => 'Example dark overlay image',
        ]);

        // Default button
        $promos['buttons']['under_menu'] = app(UnderMenu::class)->create(3, false, [
            'option' => 'Default',
        ]);

        $request->data['base']['under_menu'] = $promos['buttons']['under_menu'];

        return view('styleguide-under-menu', merge($request->data, $promos));
    }
}
