<?php

namespace Contracts\Repositories;

interface PromoRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function getPromoView($id);

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoPage($referer = null, $scheme = null, $host = null, $uri = null);

    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data);

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
