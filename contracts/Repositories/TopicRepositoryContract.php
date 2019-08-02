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
    public function listing($application_ids, $subsite_folder);

    /**
     * Find topic by id or slug.
     *
     * @param string $slug
     * @return array
     */
    public function find($slug);

    /**
     * Sort articles by letter
     *
     * @param array $topics
     * @return array
     */
    public function sortByLetter($topics);

    /**
     * Set the selected topic.
     *
     * @param array $topics
     * @param string $topic
     * @return array
     */
    public function setSelected($topics, $topic);
}
