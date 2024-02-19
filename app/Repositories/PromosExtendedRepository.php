<?php

/*
namespace App\Repositories;

use Contracts\Repositories\PromosExtendedRepositoryContract;

class PromosExtendedRepository extends PromoRepository implements PromosExtendedRepositoryContract
{
 */

/**
 * {@inheritdoc}
 */
/*
public function createGlobalPromoGroupReference(array $data, array $config, array $groups)
{
    $group_reference = parent::createGlobalPromoGroupReference($data, $config, $groups);

    // Adding a custom page field to global promos
    if (!empty($data['data']['page_field_data']) && ! array_key_exists($data['data']['page_field_data'], $group_reference)) {
        $group_reference[$data['data']['page_field_data']] = 'page_field_data';
    }

    return $group_reference;
}
 */

/**
 * {@inheritdoc}
 */
/*
public function createGlobalPromoGroupConfig(array $data, array $config, array $groups)
{
    $group_config = parent::createGlobalPromoGroupConfig($data, $config, $groups);

    // Adding a custom page field config
    $group_config['page_field_data'] = 'limit:4';

    return $group_config;
}
 */
//}
