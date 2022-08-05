<?php

namespace Styleguide\Repositories;

use App\Repositories\PaginatorRepository as Repository;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorRepository extends Repository
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
