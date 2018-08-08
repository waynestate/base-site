<?php

namespace Styleguide\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Repositories\MenuRepository as Repository;

class MenuRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {
        // If the page data has a menu use that otherwise default to 1
        $menu_id = !empty($data['menu']['id']) ? $data['menu']['id'] : 1;

        $menus = [
            $menu_id => json_decode(Storage::disk('base')->get('styleguide/menu.json'), true),
        ];

        // Return an array of all the menus needed for the view
        return $this->getMenus($data, $menus);
    }
}
