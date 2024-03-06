<?php

namespace Contracts\Repositories;

interface PromoExtendedRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function createGlobalPromoGroupReference(array $data, array $config, array $groups);

    /**
     * {@inheritdoc}
     */
    public function createGlobalPromoGroupConfig(array $data, array $config, array $groups);

    /**
     * {@inheritdoc}
     */
    public function manipulateGlobalPromos(array $promos, array $groups, array $data);
}
