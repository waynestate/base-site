<?php

namespace Styleguide\Pages;

use Contracts\Pages\StyleguidePageContract;
use Styleguide\Repositories\MenuRepository;
use Faker\Factory;

class Page implements StyleguidePageContract
{
    /** @var $path **/
    public $path;

    /**
     * @param MenuRepository $menuRepository
     * @param Factory $faker
     */
    public function __construct(MenuRepository $menuRepository, Factory $faker)
    {
        $this->menuRepository = $menuRepository;
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Childpage',
                'id' => 1,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        // Get the page data
        $page = $this->getPageData();

        // Get the menu data
        $menu = $this->menuRepository->getRequestData($page);

        // Get the item we are on
        $menu_item = end($menu['breadcrumbs']);

        // Return the path of the menu item
        if ($menu_item !== false) {
            return $menu_item['relative_url'];
        }

        // Return the custom path
        return $this->path;
    }
}
