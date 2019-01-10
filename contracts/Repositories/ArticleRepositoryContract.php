<?php

namespace Contracts\Repositories;

interface ArticleRepositoryContract
{
    /**
      * Get news ordered by display_order.
      *
      * @param int $site_id
      * @return array
      */
    public function getNewsByDisplayOrder($site_id);

    /**
     * Get news using pagination.
     *
     * @param int $site_id
     * @param int $page
     * @param int $limit
     * @param int $category_id
     * @return array
     */
    public function getNewsByPage($site_id, $page, $limit, $category_id);

    /**
     * Get individual news item.
     *
     * @param int $id
     * @param int $site_id
     * @return array
     */
    public function getNewsItem($id, $site_id);

    /**
     * Get paging information.
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPaging($page, $limit);

    /**
     * Get news categories for a site.
     *
     * @param int $site_id
     * @param string $subsite
     * @return array
     */
    public function getCategories($site_id, $subsite);

    /**
     * Set the selected category based on the slug.
     *
     * @param array $categories
     * @param string $slug
     * @return array
     */
    public function setSelectedCategory($categories, $slug);

    /**
     * Get the image url for the meta data.
     *
     * @param array $news
     * @return array
     */
    public function getImageUrl($news);

    /**
     * Set the article link based on the route
     *
     * @param array $item
     * @return array
     */
    public function setNewsLink($item);
}
