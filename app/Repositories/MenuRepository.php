<?php

namespace App\Repositories;

use Contracts\Repositories\RequestDataRepositoryContract;
use Contracts\Repositories\MenuRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;
use Exception;
use Illuminate\Support\Facades\Log;
use Waynestate\Api\Connector;
use Waynestate\Menuitems\ParseMenu;
use Waynestate\Menu\DisplayMenu;
use Illuminate\Cache\Repository;

class MenuRepository implements RequestDataRepositoryContract, MenuRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var DisplayMenu */
    protected $displayMenu;

    /** @var ParseMenu */
    protected $parseMenu;

    /** @var Repository */
    protected $cache;

    /** @var ModularPageRepositoryContract */
    protected $components;

    /**
     * Construct the repository.
     */
    public function __construct(
        Connector $wsuApi,
        ParseMenu $parseMenu,
        DisplayMenu $displayMenu,
        Repository $cache,
        ModularPageRepositoryContract $components
    ) {
        $this->wsuApi = $wsuApi;
        $this->parseMenu = $parseMenu;
        $this->displayMenu = $displayMenu;
        $this->cache = $cache;
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestData(array &$data)
    {
        // Get all the menus for this site
        try {
            $menus = $this->getAllMenus($data['site']['id'], $data['site']['parent']['id'], $data['menu']['id']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $menus = [];
        }

        // Return an array of all the menus needed for the view
        return $this->getMenus($data, $menus);
    }

    /**
     * {@inheritdoc}
     */
    public function getMenus(array $data, array $menus)
    {
        // Get the ID that will be used for the top menu
        $top_menu_id = $this->getTopMenuId($data['menu']['id'], config('base.top_menu_id'), $menus);

        // Get the top menu
        $top_menu = $top_menu_id === null ? null : $this->getTopMenu(
            $menus[$top_menu_id] ?? [],
            $data['page']['id']
        );

        $site_menu = $data['menu']['id'] === null ? null : $this->getSiteMenu(
            $menus[$data['menu']['id']] ?? [],
            $data['page']['id']
        );

        // Get the breadcrumbs
        $breadcrumbs = $this->getBreadcrumbs(
            $site_menu,
            $data['site']['title'],
            $data['site']['subsite-folder']
        );

        // Trim the sites menu if necessary
        $site_menu = $this->trimSiteMenu(
            $site_menu,
            $data['site']['parent']['id'],
            config('base.top_menu_id')
        );

        // Build the return
        $menus = [
            'site_menu' => $site_menu,
            'site_menu_output' => !empty($site_menu['menu']) ? $this->getSiteMenuOutput($site_menu['menu']) : null,
            'breadcrumbs' => $breadcrumbs,
            'top_menu' => $top_menu,
            'top_menu_output' => !empty($top_menu['menu']) ? $this->getTopMenuOutput($top_menu['menu']) : null,
        ];

        // Show the site menu by default
        $menus['show_site_menu'] = true;

        // Force hide the site menu if they specifically disable it
        if (config('base.homepage_menu_enabled') === false && $data['page']['controller'] == 'HomepageController') {
            $menus['show_site_menu'] = false;
        }

        // Hide the site menu if its equal to the top menu so the menu doesn't show twice
        if (config('base.top_menu_enabled') === true &&
            (!empty($site_menu['menu']) && !empty($top_menu['menu'])) &&
            $site_menu['menu'] == $top_menu['menu']) {
            $menus['show_site_menu'] = false;
        }

        // If no site menu is selected then hide the site menu
        if (empty($menus['site_menu_output'])) {
            $menus['show_site_menu'] = false;
        }

        // Hide the site menu or breadcrumbs with the modular-page-config component
        $menus = $this->menuDisplayToggles($menus, $data);

        // Get the surtitle
        $menus = array_merge($menus, $this->getSurtitle($data['site']));

        return $menus;
    }

    /**
     * {@inheritdoc}
     */
    public function getSiteMenuOutput($menu)
    {
        return $this->displayMenu->render(['menu' => $menu, 'menu_class' => 'main-menu']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopMenuOutput($menu)
    {
        return $this->displayMenu->render(['menu' => $menu, 'menu_class' => 'menu-top']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllMenus($site_id, $parent_id = null, $page_menu_id = null)
    {
        $params = [
            'method' => 'cms.menuitems.listing',
            'site_id' => ($parent_id !== null ? $parent_id : $site_id),
            'include_subsites' => true,
        ];

        $menus = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        // If the menu assigned to the page has no menu items set it as a blank array
        if ($page_menu_id !== null && empty($menus[$page_menu_id])) {
            $menus[$page_menu_id] = [];
        }

        if (!empty($menus['error'])) {
            throw new Exception($menus['error']['message']);
        }

        return $menus;
    }

    /**
     * {@inheritdoc}
     */
    public function getTopMenuId($menu_id = null, $top_menu_id = null, $menus = [])
    {
        return $top_menu_id !== null && !empty($menus[$top_menu_id]) ? $top_menu_id : $menu_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTopMenu($menu, $page_id = null)
    {
        $top_menu_config = [
            'display_levels' => 1,
            'page_selected' => $page_id,
        ];

        return $this->parseMenu->parse($menu, $top_menu_config);
    }

    /**
     * {@inheritdoc}
     */
    public function getSiteMenu($menu, $page_id = null)
    {
        $menu_config = [
            'page_selected' => $page_id,
        ];

        return $this->parseMenu->parse($menu, $menu_config);
    }

    /**
     * {@inheritdoc}
     */
    public function trimSiteMenu($menu, $parentId = null, $topMenuId = null)
    {
        $trim_menu = [];

        // Trim first level based on path[0] - only if we are on the main website
        // or we aren't enabling top menu across all subsites
        if (!empty($menu['meta']['path']) && ($parentId === null || $topMenuId === null) && config('base.top_menu_enabled') === true) {
            foreach ($menu['menu'] as $key => $item) {
                // If we are on the first path then grab that submenu
                if ($item['menu_item_id'] == $menu['meta']['path'][0]) {
                    $trim_menu = $menu['menu'][$key]['submenu'];
                }
            }

            // Override the menu with the trimmed version
            $menu['menu'] = $trim_menu;

            // Reset the selected state if there isn't a submenu found, that way
            // it will render a full width view
            if (empty($trim_menu)) {
                $menu['meta']['has_selected'] = false;
            }
        }

        return $menu;
    }

    /**
     * {@inheritdoc}
     */
    public function getBreadcrumbs($menu, $siteTitle = null, $subsiteFolder = null)
    {
        // Breadcrumbs to return
        $breadcrumbs = [];

        // Get the breadcrumbs from the selected path if it exists
        if (!empty($menu['meta']['path'])) {
            $breadcrumbs = $this->parseMenu->getBreadCrumbs($menu);

            // If the subsite root isn't already within the breadcrumbs then add the subsite root crumb
            if ($subsiteFolder !== null) {
                // Trim the subsite folder since the relative url from the menu doesn't end in a slash
                $rel_subsiteFolder = '/'.rtrim($subsiteFolder, '/');

                // Add the subsite path if it doesn't exist in the breadcrumbs
                if (!collect($breadcrumbs)->contains('relative_url', $rel_subsiteFolder)) {
                    $subsite_crumb = [
                        'display_name' => $siteTitle,
                        'relative_url' => $rel_subsiteFolder,
                    ];

                    $breadcrumbs = $this->parseMenu->prependBreadCrumb($breadcrumbs, $subsite_crumb);
                }
            }

            // Add the site root crumb
            $root_crumb = [
                'display_name' => 'Home',
                'relative_url' => '/',
            ];

            $breadcrumbs = $this->parseMenu->prependBreadCrumb($breadcrumbs, $root_crumb);
        }

        return $breadcrumbs;
    }

    /**
     * {@inheritdoc}
     */
    public function menuDisplayToggles($menus, $data)
    {
        // TODO: move this to a new middleware file to handle page field data and avoid looping twice
        if (array_key_exists('modular-page-config', $data['data'])) {
            foreach ($data['data'] as $componentName => $componentJSON) {
                if ($componentName === 'modular-page-config') {
                    $componentJSON = $this->components->cleanComponentJSON($componentJSON);

                    $componentJSON = json_decode($componentJSON, true);

                    if (isset($componentJSON['showPageMenu']) && $componentJSON['showPageMenu'] === false) {
                        $menus['show_site_menu'] = false;
                    }

                    if (isset($componentJSON['showBreadcrumbs']) && $componentJSON['showBreadcrumbs'] === false) {
                        $menus['breadcrumbs'] = [];
                    }
                }
            }
        }

        return $menus;
    }

    /**
     * {@inheritdoc}
     */
    public function getSurtitle(array $site)
    {
        // Prefer a sub-site's overriding surtitle, otherwise use the main site surtitle
        $surtitle = config('base.global.sites.'.$site['id'].'.surtitle') ?? config('base.surtitle');
        // Prefer a sub-site's overriding surtitle_url, otherwise use the main site surtitle
        $surtitle_url = config('base.global.sites.'.$site['id'].'.surtitle_url') ?? config('base.surtitle_url');
        // Show the surtitle only when:
        // 1) a surtitle value exists (either the sub-site's override or the global default),
        // 2) the current site is allowed to display it:
        //    - for the main site, only if `base.surtitle_main_site_enabled` is true
        //    - for sub-sites, it's allowed by default
        // 3) and this sub-site hasn't explicitly opted out via `base.global.sites.{siteId}.surtitle_disabled`.
        $hasSurtitle = (
            $surtitle !== null &&
            (
                ($site['parent']['id'] === null && config('base.surtitle_main_site_enabled') === true) ||
                ($site['parent']['id'] !== null)
            ) &&
            !config('base.global.sites.'.$site['id'].'.surtitle_disabled')
        );

        return [
            'surtitle' => $surtitle,
            'surtitle_url' => $surtitle_url,
            'hasSurtitle' => $hasSurtitle,
        ];
    }
}
