<?php

namespace App\Repositories;

use Contracts\Repositories\PaginatorRepositoryContract;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorRepository implements PaginatorRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function paginate($items, $limit, $page)
    {
        $total = count($items);
        $items = collect($items)->forPage($page, $limit);

        return new LengthAwarePaginator($items, $total, $limit, $page, ['path' => '']);
    }
}
