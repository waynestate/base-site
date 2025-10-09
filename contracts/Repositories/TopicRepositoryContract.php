<?php

namespace Contracts\Repositories;

interface TopicRepositoryContract
{
    /**
     * Topic listing.
     *
     * @param int|array $application_ids
     * @param $subsite_folder
     * @return array
     */
    public function listing(int|array $application_ids, $subsite_folder = null): array;

    /**
     * Find topic by id or slug.
     *
     * @param string $slug
     * @return array
     */
    public function find(string $slug): array;

    /**
     * Sort articles by letter
     *
     * @param array $topics
     * @return array
     */
    public function sortByLetter(array $topics): array;

    /**
     * Set the selected topic.
     *
     * @param array $topics
     * @param string|null $topic
     * @return array
     */
    public function setSelected(array $topics, ?string $topic): array;
}
