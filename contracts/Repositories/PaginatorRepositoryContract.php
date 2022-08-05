<?php

namespace Contracts\Repositories;

interface PaginatorRepositoryContract
{
    /**
     * Paginator object
     *
     * @param array $items
     * @param int $limit
     * @param int $page
     */
    public function paginate($items, $limit, $page);
}
