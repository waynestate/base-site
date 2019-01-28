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
     * @return array
     */
    public function find($id, $application_ids);

    /**
     * Get the image url for the meta data.
     *
     * @param array $article
     * @return array
     */
    public function getImageUrl($article);

    /**
     * Set the article link based on the route
     *
     * @param array $item
     * @return array
     */
    public function setArticleLink($item);
}
