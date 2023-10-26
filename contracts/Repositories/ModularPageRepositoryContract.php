<?php

namespace Contracts\Repositories;

interface ModularPageRepositoryContract
{
    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getModularComponents(array $data);
}
