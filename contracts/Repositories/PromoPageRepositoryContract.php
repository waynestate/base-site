<?php

namespace Contracts\Repositories;

interface PromoPageRepositoryContract
{
    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function getPromoView($id);

    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function getPromoPagePromos(array $data);

    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function parsePromoJSON($data);

    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function changePromoItemDisplay($promos, $group_info);

    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function organizePromoItemsByOption(array $promos);

    /**
     * Get promotions for the promo page.
     *
     * @return array
     */
    public function getBackToPromoPage($referer = null, $scheme = null, $host = null, $uri = null);
}
