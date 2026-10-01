<?php

namespace App\Console\Commands\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait AddsStyleguideMenuItems
{
    /**
     * Add a page to the submenu at the given dot path, placed before the $before entry when it exists.
     *
     * @return array{0: array, 1: int} The updated menu and the new item's id
     */
    protected function addMenuItem(array $menu, string $submenu, int $after, string $name, string $url, ?int $before = null): array
    {
        $items = Arr::get($menu, $submenu) ?: [];
        $id = $this->nextMenuItemId($menu, max([$after, ...array_keys($items)]));

        $item = [
            'menu_item_id' => $id,
            'is_active' => 1,
            'page_id' => $id,
            'target' => '',
            'display_name' => $name,
            'class_name' => '',
            'relative_url' => $url,
            'submenu' => [],
        ];

        $updated = [];
        foreach ($items as $key => $value) {
            if ($key === $before) {
                $updated[$id] = $item;
            }

            $updated[$key] = $value;
        }

        $updated[$id] = $item;

        Arr::set($menu, $submenu, $updated);

        return [$menu, $id];
    }

    /**
     * Get the next id after the given one that no menu item or page in the menu uses yet.
     */
    protected function nextMenuItemId(array $menu, int $id): int
    {
        $used = collect(Arr::dot($menu))
            ->filter(fn ($value, $key) => Str::endsWith($key, ['.menu_item_id', '.page_id']))
            ->map(fn ($value) => (int) $value);

        do {
            $id++;
        } while ($used->contains($id));

        return $id;
    }
}
