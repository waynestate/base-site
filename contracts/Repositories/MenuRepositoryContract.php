<?php

namespace Contracts\Repositories;

interface MenuRepositoryContract
{
    /**
     * Return the menus for the view.
     *
     * @param  array  $data
     * @param  array  $menus
     * @return array
     */
    public function getMenus(array $data, array $menus);

    /**
     * Get the site menu output.
     *
     * @param array $menu
     * @return array
     */
    public function getSiteMenuOutput($menu);

    /**
     * Get the top menu output.
     *
     * @param array $menu
     * @return array
     */
    public function getTopMenuOutput($menu);

    /**
     * Get the menu items and have them ready for display.
     *
     * @param int $site_id
     * @param int|null $parent_id
     * @param int $page_menu_id
     * @return array
     */
    public function getAllMenus($site_id, $parent_id, $page_menu_id);

    /**
     * Get the ID of the menu that will be used for the top menu.
     *
     * @param int|null $top_menu_id
     * @param int $menu_id
     * @param array $menus
     * @return int
     */
    public function getTopMenuId($menu_id, $top_menu_id, $menus);

    /**
     * Get the top menu.
     *
     * @param array $menu
     * @param int|null $page_id
     * @return array
     */
    public function getTopMenu($menu, $page_id);

    /**
     * Get the site's menu.
     *
     * @param array $menu
     * @param int|null $page_id
     * @return array
     */
    public function getSiteMenu($menu, $page_id);

    /**
     * Trim the site's menu.
     *
     * @param array $menu
     * @param int|null $parentId
     * @param int|null $topMenuId
     * @return array
     */
    public function trimSiteMenu($menu, $parentId, $topMenuId);

    /**
     * Get the breadcrumbs.
     *
     * @param array $menu
     * @param string|null $siteTitle
     * @param string|null $subsiteFolder
     * @return array
     */
    public function getBreadcrumbs($menu, $siteTitle, $subsiteFolder);
}
