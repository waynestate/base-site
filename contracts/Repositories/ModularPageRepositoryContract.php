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

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function cleanComponentJSON($componentJSON): string;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function parseComponentJSON(array $data);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getPromos($components, $site_id);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function configureComponents(array $components, array $promos, array $base): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function adjustPromoData($data, $component);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function organizePromoItemsByOption(array $data);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function componentClasses($components);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function componentStyles($components);

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function legacyPageFieldSupport(array $data);
}
