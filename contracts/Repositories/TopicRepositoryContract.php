<?php

namespace Contracts\Repositories;

interface TopicRepositoryContract
{
    /**
     * Find topic by id or slug.
     *
     * @param int $id
     * @param string $slug
     * @return array
     */
    public function find($id, $slug);
}
