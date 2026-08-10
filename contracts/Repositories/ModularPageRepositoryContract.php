<?php

namespace Contracts\Repositories;

interface ModularPageRepositoryContract
{
    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getModularComponents(array $data): array;

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
    public function parseComponentJSON(array $data): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function getPromos($components, $site_id): array;

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
    public function adjustPromoData($data, $component): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function organizePromoItemsByOption(array $data): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function componentClasses($components): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function componentStyles($components): array;

    /**
     * Get promotions for the listing.
     *
     * @return array
     */
    public function legacyPageFieldSupport(array $data): array;

    /**
     * Fully qualify a local or bare-domain URL using the provided base URL when needed.
     * If the base URL belongs to the current site, the URL is made relative instead.
     */
    public function fullyQualifiedUrl(string $url, string $base_url = ''): string;
}
