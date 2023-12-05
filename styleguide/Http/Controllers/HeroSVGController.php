<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;

class HeroSVGController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        config([
            'base.hero_contained' => false,
            'base.hero_full_controllers' => ['HeroSVGController'],
        ]);

        $components['components'] = [
            'accordion-1' => [
                'data' => [
                    0 => [
                        'title' => 'Configuration',
                        'description' => '
<p>Visit the modular documentation for more information</p>
<div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b">
    <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
    <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
    <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
        <pre class="w-full">modular-hero-1</pre>
    </div>
    <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{
"id":0000,
}
</pre>
    </div>
</div>
',
                        'promo_item_id' => 0,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
            'hero-1' => [
                'data' => app(HeroImage::class)->create(1, true, [
                    'option' => 'SVG Overlay',
                    'secondary_relative_url'  => "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTYwMCA1ODAiPjxzdHlsZT4uc3Qwe2ZpbGw6I2ZmZn08L3N0eWxlPjxwYXRoIGQ9Ik0wIDBoMTAwdjEwMEgwek0xNTAwIDQ4MGgxMDB2MTAwaC0xMDB6TTAgNDgwaDEwMHYxMDBIMHpNMTUwMCAwaDEwMHYxMDBoLTEwMHoiLz48cGF0aCBjbGFzcz0ic3QwIiBkPSJNMzc0LjkgNDk0LjVoLS4yTDM3MCA1MzloLTE4bC05LjMtODMuNGgxMi43bDYuOSA2NS44aC4ybDYuMi02NS44aDEyLjZsNi40IDY2LjJoLjJsNi43LTY2LjJINDA2bC05IDgzLjRoLTE3LjRsLTQuNy00NC41ek00NTMuNCA1MzloLTEzLjJsLTIuMy0xNS4xaC0xNi4xbC0yLjMgMTUuMWgtMTJsMTMuMy04My40SDQ0MGwxMy40IDgzLjR6bS0yOS45LTI2LjVoMTIuNmwtNi4yLTQyLjJoLS4ybC02LjIgNDIuMnpNNDY1LjkgNTExLjNsLTE2LjYtNTUuOEg0NjNsOS45IDM4aC4ybDkuOS0zOGgxMi41bC0xNi42IDU1LjhWNTM5aC0xMy4xdi0yNy43ek01MTIuOCA0NzguNmgtLjJWNTM5aC0xMS44di04My40aDE2LjRsMTMuMiA0OS45aC4ydi00OS45aDExLjdWNTM5aC0xMy41bC0xNi02MC40ek01NjQuOCA0OTAuN2gxOHYxMS45aC0xOFY1MjdoMjIuNnYxMmgtMzUuN3YtODMuNGgzNS43djExLjloLTIyLjZ2MjMuMnpNNjMxLjcgNDU0LjZjMTIuNyAwIDE5LjMgNy42IDE5LjMgMjF2Mi42aC0xMi40di0zLjVjMC02LTIuNC04LjItNi42LTguMnMtNi42IDIuMy02LjYgOC4yYzAgNi4xIDIuNiAxMC42IDExLjIgMTguMSAxMSA5LjYgMTQuNCAxNi42IDE0LjQgMjYuMSAwIDEzLjMtNi43IDIxLTE5LjUgMjEtMTIuOSAwLTE5LjUtNy42LTE5LjUtMjF2LTUuMWgxMi40djZjMCA2IDIuNiA4LjEgNi44IDguMSA0LjIgMCA2LjgtMi4xIDYuOC04LjEgMC02LjEtMi42LTEwLjYtMTEuMi0xOC4xLTExLTkuNi0xNC40LTE2LjYtMTQuNC0yNi4xIDAtMTMuNCA2LjUtMjEgMTkuMy0yMXpNNjU0LjggNDU1LjZoNDAuNXYxMS45aC0xMy43VjUzOWgtMTMuMXYtNzEuNWgtMTMuN3YtMTEuOXpNNzM4LjkgNTM5aC0xMy4ybC0yLjMtMTUuMWgtMTYuMUw3MDUgNTM5aC0xMmwxMy4zLTgzLjRoMTkuMmwxMy40IDgzLjR6TTcwOSA1MTIuNWgxMi42bC02LjItNDIuMmgtLjJsLTYuMiA0Mi4yek03MzYuNiA0NTUuNmg0MC41djExLjloLTEzLjdWNTM5aC0xMy4xdi03MS41aC0xMy43di0xMS45ek03OTYgNDkwLjdoMTh2MTEuOWgtMThWNTI3aDIyLjZ2MTJoLTM1Ljd2LTgzLjRoMzUuN3YxMS45SDc5NnYyMy4yek04NTcuNyA0NTUuNnY2NC4zYzAgNiAyLjYgOC4xIDYuOCA4LjEgNC4yIDAgNi44LTIuMSA2LjgtOC4xdi02NC4zaDEyLjR2NjMuNWMwIDEzLjMtNi43IDIxLTE5LjUgMjFzLTE5LjUtNy42LTE5LjUtMjF2LTYzLjVoMTN6TTkwNC41IDQ3OC42aC0uMlY1MzloLTExLjh2LTgzLjRoMTYuNGwxMy4yIDQ5LjloLjJ2LTQ5LjlIOTM0VjUzOWgtMTMuNWwtMTYtNjAuNHpNOTQzLjQgNDU1LjZoMTMuMVY1MzloLTEzLjF2LTgzLjR6TTk4NS43IDUyMy42aC4ybDkuOS02OGgxMkw5OTUgNTM5aC0xOS41bC0xMi45LTgzLjRoMTMuMmw5LjkgNjh6TTEwMjcuMSA0OTAuN2gxOHYxMS45aC0xOFY1MjdoMjIuNnYxMkgxMDE0di04My40aDM1Ljd2MTEuOWgtMjIuNnYyMy4yek0xMDg1LjIgNTM5Yy0uNy0yLjEtMS4yLTMuNS0xLjItMTAuMnYtMTMuMWMwLTcuNy0yLjYtMTAuNi04LjYtMTAuNmgtNC41djM0aC0xMy4xdi04My40aDE5LjhjMTMuNiAwIDE5LjQgNi4zIDE5LjQgMTkuMnY2LjZjMCA4LjYtMi43IDE0LjEtOC42IDE2Ljh2LjJjNi42IDIuNyA4LjcgOC45IDguNyAxNy42VjUyOWMwIDQuMS4xIDcgMS40IDEwLjFoLTEzLjN6bS0xNC4zLTcxLjV2MjUuNmg1LjFjNC45IDAgNy45LTIuMSA3LjktOC44di04LjJjMC02LTItOC42LTYuNy04LjZoLTYuM3pNMTEyMy4zIDQ1NC42YzEyLjcgMCAxOS4zIDcuNiAxOS4zIDIxdjIuNmgtMTIuNHYtMy41YzAtNi0yLjQtOC4yLTYuNi04LjItNC4yIDAtNi42IDIuMy02LjYgOC4yIDAgNi4xIDIuNiAxMC42IDExLjIgMTguMSAxMSA5LjYgMTQuNCAxNi42IDE0LjQgMjYuMSAwIDEzLjMtNi43IDIxLTE5LjUgMjFzLTE5LjUtNy42LTE5LjUtMjF2LTUuMWgxMi40djZjMCA2IDIuNiA4LjEgNi44IDguMSA0LjIgMCA2LjgtMi4xIDYuOC04LjEgMC02LjEtMi42LTEwLjYtMTEuMi0xOC4xLTExLTkuNi0xNC40LTE2LjYtMTQuNC0yNi4xIDAtMTMuNCA2LjYtMjEgMTkuMy0yMXpNMTE1MC4zIDQ1NS42aDEzLjFWNTM5aC0xMy4xdi04My40ek0xMTY5LjEgNDU1LjZoNDAuNXYxMS45aC0xMy43VjUzOWgtMTMuMXYtNzEuNWgtMTMuN3YtMTEuOXpNMTIyNy42IDUxMS4zbC0xNi42LTU1LjhoMTMuN2w5LjkgMzhoLjJsOS45LTM4aDEyLjVsLTE2LjYgNTUuOFY1MzloLTEzLjF2LTI3Ljd6Ii8+PC9zdmc+",
                ]),
            ],
        ];

        $request->data['base']['hero'] = $components['components']['hero-1'];

        return view('childpage', merge($request->data, $components));
    }
}