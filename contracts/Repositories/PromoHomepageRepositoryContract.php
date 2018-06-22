<?php

namespace Contracts\Repositories;

interface PromoHomepageRepositoryContract
{
    /**
     * Get promotions for the homepage.
     *
     * @return array
     */
    public function get();
}
