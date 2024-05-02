<?php

namespace Contracts\Repositories;

interface HomepageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(array $data): array;
}
