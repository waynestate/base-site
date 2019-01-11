<?php

namespace Contracts\Repositories;

interface TopicRepositoryContract
{
    /**
     * Topic listing.
     *
     * @param array $application_ids
     * @return array
     */
    public function listing($application_ids);

    /**
     * Find topic by id or slug.
     *
     * @param int $id
     * @param string $slug
     * @return array
     */
    public function find($id, $slug);
}
