<?php

namespace Styleguide\Repositories;

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
            $menu_id => [
                100 => [
                    'menu_item_id' => '100',
                    'is_active' => '1',
                    'page_id' => '100',
                    'target' => '',
                    'display_name' => 'Content area',
                    'class_name' => '',
                    'relative_url' => '/styleguide',
                    'submenu' => [],
                ],
                101 => [
                    'menu_item_id' => '101',
                    'is_active' => '1',
                    'page_id' => '101',
                    'target' => '',
                    'display_name' => 'Templates',
                    'class_name' => '',
                    'relative_url' => '/styleguide/childpage',
                    'submenu' => [
                        101100 => [
                            'menu_item_id' => '101100',
                            'is_active' => '1',
                            'page_id' => '101100',
                            'target' => '',
                            'display_name' => 'Childpage',
                            'class_name' => '',
                            'relative_url' => '/styleguide/childpage',
                            'submenu' => [],
                        ],
                        101101 => [
                            'menu_item_id' => '101101',
                            'is_active' => '1',
                            'page_id' => null, // Null value to mimic the homepage not being in the menu
                            'target' => '',
                            'display_name' => 'Homepage',
                            'class_name' => '',
                            'relative_url' => '/styleguide/homepage',
                            'submenu' => [],
                        ],
                        101102 => [
                            'menu_item_id' => '101102',
                            'is_active' => '1',
                            'page_id' => '101102',
                            'target' => '',
                            'display_name' => 'News',
                            'class_name' => '',
                            'relative_url' => '/styleguide/news',
                            'submenu' => [],
                        ],
                        101103 => [
                            'menu_item_id' => '101103',
                            'is_active' => '1',
                            'page_id' => '101103',
                            'target' => '',
                            'display_name' => 'Profiles',
                            'class_name' => '',
                            'relative_url' => '/styleguide/profiles',
                            'submenu' => [],
                        ],
                        101104 => [
                            'menu_item_id' => '101104',
                            'is_active' => '1',
                            'page_id' => '101104',
                            'target' => '',
                            'display_name' => 'Directory',
                            'class_name' => '',
                            'relative_url' => '/styleguide/directory',
                            'submenu' => [],
                        ],
                        101105 => [
                            'menu_item_id' => '101105',
                            'is_active' => '1',
                            'page_id' => null,
                            'target' => '',
                            'display_name' => 'Full width content area',
                            'class_name' => '',
                            'relative_url' => '/styleguide/fullwidth',
                            'submenu' => [],
                        ],
                    ],
                ],
                102 => [
                    'menu_item_id' => '102',
                    'is_active' => '1',
                    'page_id' => '102',
                    'target' => '',
                    'display_name' => 'Components',
                    'class_name' => '',
                    'relative_url' => '/styleguide/components',
                    'submenu' => [
                        102100 => [
                            'menu_item_id' => '102100',
                            'is_active' => '1',
                            'page_id' => '102100',
                            'target' => '',
                            'display_name' => 'Header title',
                            'class_name' => '',
                            'relative_url' => '/styleguide/header/title/single',
                            'submenu' => [
                                102100100 => [
                                    'menu_item_id' => '102100100',
                                    'is_active' => '1',
                                    'page_id' => '102100100',
                                    'target' => '',
                                    'display_name' => 'Header title single',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/header/title/single',
                                    'submenu' => [],
                                ],
                                102100101 => [
                                    'menu_item_id' => '102100101',
                                    'is_active' => '1',
                                    'page_id' => '102100101',
                                    'target' => '',
                                    'display_name' => 'Header title double',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/header/title/double/',
                                    'submenu' => [],
                                ],
                            ],
                        ],
                        103100 => [
                            'menu_item_id' => '103100',
                            'is_active' => '1',
                            'page_id' => '103100',
                            'target' => '',
                            'display_name' => 'Menu',
                            'class_name' => '',
                            'relative_url' => '/styleguide/menu/left',
                            'submenu' => [
                                103100100 => [
                                    'menu_item_id' => '103100100',
                                    'is_active' => '1',
                                    'page_id' => '103100100',
                                    'target' => '',
                                    'display_name' => 'Menu left',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/menu/left',
                                    'submenu' => [],
                                ],
                                103100101 => [
                                    'menu_item_id' => '103100101',
                                    'is_active' => '1',
                                    'page_id' => '103100101',
                                    'target' => '',
                                    'display_name' => 'Menu top',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/menu/top',
                                    'submenu' => [],
                                ],
                            ],
                        ],
                        104100 => [
                            'menu_item_id' => '104100',
                            'is_active' => '1',
                            'page_id' => '104100',
                            'target' => '',
                            'display_name' => 'Footer contact',
                            'class_name' => '',
                            'relative_url' => '/styleguide/footer/contact/one',
                            'submenu' => [
                                104100100 => [
                                    'menu_item_id' => '104100100',
                                    'is_active' => '1',
                                    'page_id' => '104100100',
                                    'target' => '',
                                    'display_name' => 'One column',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/footer/contact/one',
                                    'submenu' => [],
                                ],
                                104100101 => [
                                    'menu_item_id' => '104100101',
                                    'is_active' => '1',
                                    'page_id' => '104100101',
                                    'target' => '',
                                    'display_name' => 'Two column',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/footer/contact/two',
                                    'submenu' => [],
                                ],
                                104100102 => [
                                    'menu_item_id' => '104100102',
                                    'is_active' => '1',
                                    'page_id' => '104100102',
                                    'target' => '',
                                    'display_name' => 'Three column',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/footer/contact/three',
                                    'submenu' => [],
                                ],
                            ],
                        ],
                        105100 => [
                            'menu_item_id' => '105100',
                            'is_active' => '1',
                            'page_id' => '105100',
                            'target' => '',
                            'display_name' => 'Hero image',
                            'class_name' => '',
                            'relative_url' => '/styleguide/hero/contained',
                            'submenu' => [
                                105100100 => [
                                    'menu_item_id' => '105100100',
                                    'is_active' => '1',
                                    'page_id' => '105100100',
                                    'target' => '',
                                    'display_name' => 'Contained',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/contained',
                                    'submenu' => [],
                                ],
                                105100101 => [
                                    'menu_item_id' => '105100101',
                                    'is_active' => '1',
                                    'page_id' => '105100101',
                                    'target' => '',
                                    'display_name' => 'Contained (rotate)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/contained/rotate',
                                    'submenu' => [],
                                ],
                                105100102 => [
                                    'menu_item_id' => '105100102',
                                    'is_active' => '1',
                                    'page_id' => '105100102',
                                    'target' => '',
                                    'display_name' => 'Contained (with text)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/contained/text',
                                    'submenu' => [],
                                ],
                                105100103 => [
                                    'menu_item_id' => '105100103',
                                    'is_active' => '1',
                                    'page_id' => '105100103',
                                    'target' => '',
                                    'display_name' => 'Contained (with text/link)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/contained/text/link',
                                    'submenu' => [],
                                ],
                                105100104 => [
                                    'menu_item_id' => '105100104',
                                    'is_active' => '1',
                                    'page_id' => null,
                                    'target' => '',
                                    'display_name' => 'Full width',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/full',
                                    'submenu' => [],
                                ],
                                105100105 => [
                                    'menu_item_id' => '105100105',
                                    'is_active' => '1',
                                    'page_id' => '105100105',
                                    'target' => '',
                                    'display_name' => 'Full width (rotate)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/full/rotate',
                                    'submenu' => [],
                                ],
                                105100106 => [
                                    'menu_item_id' => '105100106',
                                    'is_active' => '1',
                                    'page_id' => null,
                                    'target' => '',
                                    'display_name' => 'Full width (menu)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/full/menu',
                                    'submenu' => [],
                                ],
                                105100107 => [
                                    'menu_item_id' => '105100107',
                                    'is_active' => '1',
                                    'page_id' => null,
                                    'target' => '',
                                    'display_name' => 'Full width (text/link)',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/hero/full/text/link',
                                    'submenu' => [],
                                ],
                            ],
                        ],
                        106100 => [
                            'menu_item_id' => '106100',
                            'is_active' => '1',
                            'page_id' => '106100',
                            'target' => '',
                            'display_name' => 'Error pages',
                            'class_name' => '',
                            'relative_url' => '/styleguide/error',
                            'submenu' => [
                                106100100 => [
                                    'menu_item_id' => '106100100',
                                    'is_active' => '1',
                                    'page_id' => '106100100',
                                    'target' => '',
                                    'display_name' => 'Error 403',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/error/403',
                                    'submenu' => [],
                                ],
                                106100101 => [
                                    'menu_item_id' => '106100101',
                                    'is_active' => '1',
                                    'page_id' => '106100101',
                                    'target' => '',
                                    'display_name' => 'Error 404',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/error/404',
                                    'submenu' => [],
                                ],
                                106100102 => [
                                    'menu_item_id' => '106100102',
                                    'is_active' => '1',
                                    'page_id' => '106100102',
                                    'target' => '',
                                    'display_name' => 'Error 500',
                                    'class_name' => '',
                                    'relative_url' => '/styleguide/error/500',
                                    'submenu' => [],
                                ],
                            ],
                        ],
                        107100 => [
                            'menu_item_id' => '107100',
                            'is_active' => '1',
                            'page_id' => '107100',
                            'target' => '',
                            'display_name' => 'Accordion',
                            'class_name' => '',
                            'relative_url' => '/styleguide/accordion',
                            'submenu' => [],
                        ],
                        108100 => [
                            'menu_item_id' => '108100',
                            'is_active' => '1',
                            'page_id' => '108100',
                            'target' => '',
                            'display_name' => 'Image/button list',
                            'class_name' => '',
                            'relative_url' => '/styleguide/image/button/list',
                            'submenu' => [],
                        ],
                        109100 => [
                            'menu_item_id' => '109100',
                            'is_active' => '1',
                            'page_id' => '109100',
                            'target' => '',
                            'display_name' => 'Image list rotate',
                            'class_name' => '',
                            'relative_url' => '/styleguide/image/list/rotate',
                            'submenu' => [],
                        ],
                        110100 => [
                            'menu_item_id' => '110100',
                            'is_active' => '1',
                            'page_id' => '110100',
                            'target' => '',
                            'display_name' => 'Mini news',
                            'class_name' => '',
                            'relative_url' => '/styleguide/mininews',
                            'submenu' => [],
                        ],
                        111100 => [
                            'menu_item_id' => '111100',
                            'is_active' => '1',
                            'page_id' => '111100',
                            'target' => '',
                            'display_name' => 'Mini events',
                            'class_name' => '',
                            'relative_url' => '/styleguide/minievents',
                            'submenu' => [],
                        ],
                        112100 => [
                            'menu_item_id' => '112100',
                            'is_active' => '1',
                            'page_id' => '112100',
                            'target' => '',
                            'display_name' => 'Mini list',
                            'class_name' => '',
                            'relative_url' => '/styleguide/minilist',
                            'submenu' => [],
                        ],
                        113100 => [
                            'menu_item_id' => '113100',
                            'is_active' => '1',
                            'page_id' => '113100',
                            'target' => '',
                            'display_name' => 'Forms',
                            'class_name' => '',
                            'relative_url' => '/styleguide/forms',
                            'submenu' => [],
                        ],
                        114100 => [
                            'menu_item_id' => '114100',
                            'is_active' => '1',
                            'page_id' => '114100',
                            'target' => '',
                            'display_name' => 'Banner',
                            'class_name' => '',
                            'relative_url' => '/styleguide/banner',
                            'submenu' => [],
                        ],
                        115100 => [
                            'menu_item_id' => '115100',
                            'is_active' => '1',
                            'page_id' => '115100',
                            'target' => '',
                            'display_name' => 'Table stack',
                            'class_name' => '',
                            'relative_url' => '/styleguide/tablestack',
                            'submenu' => [],
                        ],
                    ],
                ],
            ],
        ];

        // Return an array of all the menus needed for the view
        return $this->getMenus($data, $menus);
    }
}
