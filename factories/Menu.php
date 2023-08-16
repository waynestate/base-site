<?php

namespace Factories;

use Factories\Menu;
use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Menu implements FactoryContract
{
    /** @var $child_items **/
    protected $child_items = false;

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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'menu_item_id' => $i,
                'is_active' => 1,
                'page_id' => $i,
                'target' => '',
                'display_name' => $this->faker->sentence(3),
                'class_name' => '',
                'relative_url' => '/'.$this->faker->word().$this->faker->word(),
                'submenu' => [],
            ];

            if ($this->child_items == true) {
                for ($j = 1; $j <= $limit; $j++) {
                    $data[$i]['submenu'][$j] = [
                        'menu_item_id' => $i.$j,
                        'page_id' => $i.$j,
                        'is_active' => 1,
                        'target' => '',
                        'display_name' => $this->faker->sentence(3),
                        'class_name' => '',
                        'relative_url' => '/'.$this->faker->word().$this->faker->word(),
                        'submenu' => [],
                    ];

                    $data[$i]['submenu'][$j] = array_replace_recursive($data[$i]['submenu'][$j], $options);
                }
            }

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }

    /**
     * Set child items.
     */
    public function withChildItems(): Menu
    {
        $this->setChildItems(true);

        return $this;
    }

    /**
     * Setter for child items config.
     *
     * @param bool $boolean [description]
     */
    public function setChildItems(bool $boolean)
    {
        $this->child_items = $boolean;
    }

    /**
     * Getter for child items config.
     */
    public function getChildItems(): bool
    {
        return $this->child_items;
    }
}
