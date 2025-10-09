<?php

namespace Contracts\Repositories;

interface HomepageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(array $data): array;

    /**
     * Get the homepage components
     *
     * @param array $data
     * @return array
     */
    public function getHomepageComponents(array $data): array;
}
