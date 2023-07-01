<?php

namespace Contracts\Repositories;

interface PromoPageRepositoryContract
{
    /**
     *
     * @return array
     */
    public function getPromoView($id);

    /**
     *
     * @return array
     */
    public function getPromoPagePromos(array $data);

    /**
     *
     * @return array
     */
    public function parsePromoJSON($data);

    /**
     *
     * @return array
     */
    public function changePromoItemDisplay($promos, $group_info);

    /**
     *
     * @return array
     */
    public function organizePromoItemsByOption(array $promos);

    /**
     *
     * @return array
     */
    public function getBackToPromoPage($referer = null, $scheme = null, $host = null, $uri = null);
}
