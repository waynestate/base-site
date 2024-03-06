<?php

namespace App\Repositories;

use Contracts\Repositories\PromoExtendedRepositoryContract;

class PromoExtendedRepository extends PromoRepository implements PromoExtendedRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function createGlobalPromoGroupReference(array $data, array $config, array $groups)
    {
        $group_reference = parent::createGlobalPromoGroupReference($data, $config, $groups);

        /*
        // Custom page field
        if (!empty($data['data']['page_field_promo_group_id']) && ! array_key_exists($data['data']['page_field_promo_group_id'], $group_reference)) {
            $group_reference[$data['data']['page_field_promo_group_id']] = 'page_field_label';
        }
         */

        return $group_reference;
    }

    /**
     * {@inheritdoc}
     */
    public function createGlobalPromoGroupConfig(array $data, array $config, array $groups)
    {
        $group_config = parent::createGlobalPromoGroupConfig($data, $config, $groups);

        // $group_config['page_field_label'] = 'randomize|limit:4|{$page_id}';

        return $group_config;
    }

    /**
     * {@inheritdoc}
     */
    public function manipulateGlobalPromos(array $promos, array $groups, array $data)
    {
        $promos = parent::manipulateGlobalPromos($promos, $groups, $data);

        return $promos;
    }
}
