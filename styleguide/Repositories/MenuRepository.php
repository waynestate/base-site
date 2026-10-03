<?php

namespace Styleguide\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Repositories\MenuRepository as Repository;

class MenuRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getRequestData(array &$data)
    {
        // If the page data has a menu use that otherwise default to 1
        $menu_id = !empty($data['menu']['id']) ? $data['menu']['id'] : 1;

        $baseMenu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);

        $siteNamespace = config('base.site_namespace', 'Site');
        $siteMenuPath = 'app/'.$siteNamespace.'/Styleguide/menu.json';

        if (Storage::disk('base')->exists($siteMenuPath)) {
            $siteMenu = json_decode(Storage::disk('base')->get($siteMenuPath), true);
            if (is_array($siteMenu)) {
                $baseMenu = array_replace_recursive($baseMenu, $siteMenu);
            }
        }

        $menus = [
            $menu_id => $baseMenu,
        ];

        // Return an array of all the menus needed for the view
        return $this->getMenus($data, $menus);
    }
}
