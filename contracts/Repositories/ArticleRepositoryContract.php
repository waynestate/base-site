<?php

namespace Contracts\Repositories;

interface ArticleRepositoryContract
{
    /**
     * Get articles by application and topics.
     *
     * @param array $application_ids
     * @param int $limit
     * @param int $page
     * @param array $topics
     * @return array
     */
    public function listing($application_ids, $limit=5, $page=1, $topics=[]);

    /**
     * Get an individual article by id.
     *
     * @param int $id
     * @param array $application_ids
     * @param boolean|null $preview
     * @return array
     */
    public function find($id, $application_ids, $preview);

    /**
     * Get the image for the meta data.
     *
     * @param array $article
     * @return array
     */
    public function getImage($article);

    /**
     * Set the paging.
     *
     * @param array $meta
     * @param int $page
     * @return array
     */
    public function setPaging($meta, $page);
}
