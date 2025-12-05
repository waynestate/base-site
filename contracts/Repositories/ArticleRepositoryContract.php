<?php

namespace Contracts\Repositories;

interface ArticleRepositoryContract
{
    /**
     * Get articles by application and topics.
     *
     * @param  array  $application_ids
     * @param  int  $limit
     * @param  int  $page
     * @param  array  $topics
     * @return array
     */
    public function listing($application_ids, $limit = 5, $page = 1, $topics = []);

    /**
     * Get an individual article by id.
     *
     * @param  int  $id
     * @param  array  $application_ids
     * @param  bool|null  $preview
     * @return array
     */
    public function find($id, $application_ids, $preview);

    /**
     * Build the fully qualified URI for the article
     *
     * @return array|string
     */
    public function getCanonicalUrl(array $article, array $request);

    /**
     * Get the image for the meta data.
     *
     * @param  array  $article
     * @return array
     */
    public function getSocialImage($article);

    /**
     * Set the paging.
     */
    public function setPaging(array $meta, ?int $page): array;
}
