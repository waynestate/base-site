<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class ComponentHeroController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Hero Controller
     */
    public function index(Request $request): View
    {
        $hero_config = $this->getHeroConfig($request->data);

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'component_config',
                        'description' => '<p>Note: Any limit above 1 will enable the carousel.</p>',
                        'tr1' => [
                            'Page field' => 'modular-hero-1',
                            'Data' => '{
"id":'.$hero_config['id'].',
"option":"'.$hero_config['option'].'",
"config":"limit:'.$hero_config['limit'].'"
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Displayed using options "Text overlay," "Logo overlay" and will become a link if link field is used.',
                            'Link' => 'URL',
                            'Description' => 'Formattable text. If the link field is set, description links will be stripped out.',
                            'Filename' => '1600x580px or 3200x1160px saved at low quality',
                            'Secondary image' => 'SVG Overlay: 1600x580px or 3200x1160px svg<br />Logo overlay: >600px jpg, png',
                            'Options' => 'Banner small, Banner large, Text overlay, Half, Logo overlay, SVG overlay, Contained',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }

    /**
     * Get the hero configuration for the styleguide.
     *
     * @param array $data
     * @return array
     */
    private function getHeroConfig(array $data): array
    {
        $id = $data['page']['id'] ?? 0000;
        $title = $data['page']['title'] ?? '';

        $hero_type = $data['base']['hero']['component']['heroType'] ?? '';
        $hero_layout = $data['base']['hero']['component']['heroLayout'] ?? '';
        $hero_placement = $data['base']['hero']['component']['heroPlacement'] ?? '';

        // If page data is missing, check hero data (common on styleguide pages)
        if (($id === 0000 || $id === 0) && ! empty($data['base']['hero']['data'])) {
            $hero = current($data['base']['hero']['data']);
            $id = $id === 0000 || $id === 0 ? ($hero['id'] ?? $id) : $id;
            $title = $hero['title'] ?? $title;
        }

        $option = '';
        $limit = 1;

        // Map hero types to their corresponding options and limits
        $type_map = [
            'text' => ['option' => 'text'],
            'svg' => ['option' => 'svg'],
            'logo' => ['option' => 'logo'],
            'large' => ['option' => 'large'],
            'slim' => ['option' => 'small'],
            'split' => ['option' => 'half'],
            'buttons' => ['option' => 'buttons'],
        ];

        if (isset($type_map[$hero_type])) {
            $option = $type_map[$hero_type]['option'] ?? $option;
            $limit = $type_map[$hero_type]['limit'] ?? $limit;
        }

        if ($hero_layout === 'carousel') {
            $limit = 3;
        }

        if ($hero_placement === 'contained') {
            $option .= ($option !== '' ? ' ' : '').'contained';
        }

        if ($hero_layout === 'carousel' && $hero_placement !== 'contained') {
            $option .= ($option !== '' ? ' ' : '').'full';
        }

        return [
            'id' => $id,
            'title' => $title,
            'option' => $option,
            'limit' => $limit,
        ];
    }
}
