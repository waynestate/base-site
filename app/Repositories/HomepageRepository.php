<?php

namespace App\Repositories;

use Contracts\Repositories\HomepageRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;
use App\Traits\StaleCache;
use App\Traits\FiltersExpiredItems;

class HomepageRepository implements HomepageRepositoryContract
{
    use StaleCache;
    use FiltersExpiredItems;

    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /** @var ModularPageRepositoryContract */
    protected $components;

    /**
     * Construct the repository.
     */
    public function __construct(
        Connector $wsuApi,
        ParsePromos $parsePromos,
        Repository $cache,
        ModularPageRepositoryContract $components,
    ) {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(array $data): array
    {
        $group_reference = [
            123 => 'example',
        ];

        $group_config = [
            'example' => 'randomize|first',
        ];

        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($group_reference),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->rememberWithFallback($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        if (!empty($promos['promotions'])) {
            $promos['promotions'] = $this->filterExpiredItems($promos['promotions'], ['end_date', 'display_end_date']);
        }

        return $this->parsePromos->parse($promos, $group_reference, $group_config);
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepageComponents(array $data): array
    {
        $component_exists = false;

        // Allow news-and-events to be overwritten by the matching page field component if it exists
        if (!empty($data['data'])) {
            foreach ($data['data'] as $componentName => $componentConfig) {
                if (stristr($componentName, 'news-and-events') !== false) {
                    $component_exists = true;
                    break;
                }
            }
        }

        // Create news and events component
        if ($component_exists === false) {
            $data['data'] = [
                'modular-news-and-events-row' => "{}",
            ];
        }

        // Send news and events component data thru modular repository
        $homepage_components = $this->components->getModularComponents($data);

        if (empty($data['components'])) {
            $data['components'] = [];
        }

        // Merge this component with existing components
        $data['components'] = array_merge($data['components'], $homepage_components);

        return $data;
    }
}
