<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Icon implements FactoryContract
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function create($limit = 1, $flatten = false, $options = [])
    {
        $icon_green = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjAuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMDAgMTAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzA4MzUyRjt9Cjwvc3R5bGU+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01MCwyLjVDMjMuOCwyLjUsMi41LDIzLjgsMi41LDUwUzIzLjgsOTcuNSw1MCw5Ny41Uzk3LjUsNzYuMiw5Ny41LDUwUzc2LjIsMi41LDUwLDIuNXogTTQzLjgsMjAuOQoJYzEuNi0xLjUsMy41LTIuMiw1LjYtMi4yYzIuMiwwLDQuMSwwLjcsNS42LDIuMmMxLjYsMS41LDIuMywzLjIsMi4zLDUuM2MwLDItMC44LDMuOC0yLjQsNS4yYy0xLjYsMS40LTMuNCwyLjItNS42LDIuMgoJYy0yLjIsMC00LjEtMC43LTUuNi0yLjJjLTEuNi0xLjQtMi40LTMuMi0yLjQtNS4yQzQxLjQsMjQuMSw0Mi4yLDIyLjMsNDMuOCwyMC45eiBNNjMuMyw4MS4zSDM3Ljd2LTNjMC43LTAuMSwxLjQtMC4xLDIuMS0wLjIKCXMxLjMtMC4yLDEuNy0wLjRjMC45LTAuMywxLjUtMC44LDEuOC0xLjRzMC41LTEuNCwwLjUtMi40VjUwLjRjMC0wLjktMC4yLTEuOC0wLjYtMi41Yy0wLjQtMC43LTEtMS4zLTEuNi0xLjcKCWMtMC41LTAuMy0xLjItMC42LTIuMi0wLjlzLTEuOS0wLjUtMi43LTAuNnYtM2wxOS44LTEuMWwwLjYsMC42djMyLjFjMCwwLjksMC4yLDEuNywwLjYsMi40YzAuNCwwLjcsMSwxLjIsMS43LDEuNQoJYzAuNSwwLjIsMS4xLDAuNSwxLjgsMC42YzAuNiwwLjIsMS4zLDAuMywyLDAuNHYzLjFDNjMuMiw4MS4zLDYzLjMsODEuMyw2My4zLDgxLjN6Ii8+Cjwvc3ZnPgo=";

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'link' => '#',
                //'title' => 'Step '.$i,
                'title' => ucfirst(implode(' ', $this->faker->words(2))),
                'excerpt' => ucfirst(implode(' ', $this->faker->words(5))),
                'description' => '<p>'.ucfirst(implode(' ', $this->faker->words(10))).' <a href="#">'.implode(' ', $this->faker->words(2)).'</a>.</p>',
                //'description' => '<p>' . $this->faker->text(20) . ' <a href="https://wayne.edu">'. $this->faker->sentence(3)  .'</a></p>',
                'promo_item_id' => $i,
                'relative_url' => $icon_green,
                'filename_alt_text' => 'Placeholder icon '.$i,
                'option' => '',
                'group' => [
                    'title' => 'Promo group title',
                ],
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
