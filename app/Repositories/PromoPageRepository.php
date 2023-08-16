<?php

namespace App\Repositories;

use Contracts\Repositories\PromoPageRepositoryContract;
use Illuminate\Cache\Repository;
use Illuminate\Support\Str;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class PromoPageRepository implements PromoPageRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param Connector $wsuApi
     * @param ParsePromos $parsePromos
     * @param Repository $cache
     */
    public function __construct(Connector $wsuApi, ParsePromos $parsePromos, Repository $cache)
    {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoView($id)
    {
        $promo['promotion'] = [];

        $params = [
            'method' => 'cms.promotions.info',
            'promo_item_id' => $id,
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promo = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $promo['promo'] = empty($promo['error']) ? $promo['promotion'] : [];

        return $promo;
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoPagePromos(array $data)
    {
        // Legacy support for listing
        if (!empty($data['data']['listing_promo_group_id'])) {
            if (!empty($data['data']['promotion_view_boolean']) && $data['data']['promotion_view_boolean'] === "true") {
                $data['data']['promoPage'] = "{\"id\":\"".$data['data']['listing_promo_group_id']."\",\"singlePromoView\":\"true\"}";
            } else {
                $data['data']['promoPage'] = "{\"id\":\"".$data['data']['listing_promo_group_id']."\"}";
            }
        }

        // Legacy support for grid
        if (!empty($data['data']['grid_promo_group_id'])) {
            if (!empty($data['data']['promotion_view_boolean']) && $data['data']['promotion_view_boolean'] === "true") {
                $data['data']['promoPage'] = "{\"id\":\"".$data['data']['grid_promo_group_id']."\",\"columns\":\"3\",\"singlePromoView\":\"true\"}";
            } else {
                $data['data']['promoPage'] = "{\"id\":\"".$data['data']['grid_promo_group_id']."\",\"columns\":\"3\"}";
            }
        }

        if (!empty($data['data']['promoPage'])) {
            $group_info = $this->parsePromoJSON($data);

            // Parse promos
            $group_reference[$group_info['id']] = 'promos';
            $group_config['promos'] = $group_info['config'];

            $params = [
                'method' => 'cms.promotions.listing',
                'promo_group_id' => array_keys($group_reference),
                'filename_url' => true,
                'is_active' => '1',
            ];

            $promos = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
                return $this->wsuApi->sendRequest($params['method'], $params);
            });

            $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

            // Manipulate promo data from page field settings
            $promos = $this->changePromoItemDisplay($promos, $group_info);

            // Organize promos by option
            $promos = $this->organizePromoItemsByOption($promos);

            // Set number of columns
            $promos['template']['columns'] = $group_info['columns'];

            return $promos;
        } else {
            return ['promos' => []];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parsePromoJSON($data)
    {
        $group_info = [];

        if (!empty($data['data']['promoPage'])) {
            // Remove all spaces and line breaks
            $group_info = preg_replace('/\s*\R\s*/', '', $data['data']['promoPage']);

            // Last item cannot have comma at the end of it
            $group_info = preg_replace('(,})', '}', $group_info);

            // JSON into array
            $group_info = json_decode($group_info, true);

            // Assign expected group info
            $group_info['id'] = (!empty($group_info['id']) ? $group_info['id'] : '');
            $group_info['config'] = (!empty($group_info['config']) ? $group_info['config'] : '');
            $group_info['singlePromoView'] = (!empty($group_info['singlePromoView']) ? $group_info['singlePromoView'] : '');
            $group_info['columns'] = (!empty($group_info['columns']) ? $group_info['columns'] : '');
            $group_info['showExcerpt'] = (!empty($group_info['showExcerpt']) ? $group_info['showExcerpt'] : '');
            $group_info['showDescription'] = (!empty($group_info['showDescription']) ? $group_info['showDescription'] : '');

            // Append actual page id to config
            if (str_contains($group_info['config'], 'page_id')) {
                $group_info['config'] = preg_replace('/\bpage_id\b/', 'page_id:'.$data['page']['id'], $group_info['config']);
            }
        }

        return $group_info;
    }

    /**
     * {@inheritdoc}
     */
    public function changePromoItemDisplay($promos, $group_info)
    {
        // Enable the individual promotion view
        if ($group_info['singlePromoView'] == "true") {
            $promos['promos'] = collect($promos['promos'])->map(function ($item) {
                if (!empty($item)) {
                    $item['link'] = 'view/'.Str::slug($item['title']).'-'.$item['promo_item_id'];
                }

                return $item;
            })->toArray();
        }

        // Hide excerpt
        if ($group_info['showExcerpt'] == "false") {
            $promos['promos'] = collect($promos['promos'])->map(function ($item) {
                unset($item['excerpt']);

                return $item;
            })->toArray();
        }

        // Hide description
        if ($group_info['showDescription'] == "false") {
            $promos['promos'] = collect($promos['promos'])->map(function ($item) {
                unset($item['description']);

                return $item;
            })->toArray();
        }

        return $promos;
    }

    /**
    * {@inheritdoc}
    */
    public function organizePromoItemsByOption(array $promos)
    {
        $options_exist = collect($promos['promos'])->filter(function ($value) {
            return !empty($value['option']);
        })->isNotEmpty();

        if ($options_exist === true) {
            $promos['promos'] = collect($promos['promos'])->groupBy('option')->toArray();

            if (!empty($promos['promos'][''])) {
                $no_option_moved_to_bottom = $promos['promos'][''];
                unset($promos['promos']['']);
                $promos['promos'][''] = $no_option_moved_to_bottom;
            }

            $promos['template']['group_by_options'] = true;
        } else {
            $promos['template']['group_by_options'] = false;
        }

        return $promos;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoPage($referer = null, $scheme = null, $host = null, $uri = null)
    {
        // Make sure the referer is coming from the site we are currently on and not the current page
        if ($referer === null
            || $referer == $scheme.'://'.$host.$uri
            || strpos($referer, $host) === false
        ) {
            return '';
        }

        return $referer;
    }
}
