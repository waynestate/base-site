<?php

namespace Contracts\Repositories;

interface HomepageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(int $page_id = 0);
}
