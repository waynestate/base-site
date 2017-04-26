<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Cache\Repository;

class RedisClear extends Command
{
    /**
     * redis:clear command.
     *
     * @var string
     */
    protected $signature = 'redis:clear';

    /**
     * Clean out the REDIS cache for the site cache prefix.
     *
     * @var string
     */
    protected $description = 'Clean out the REDIS cache for the site cache prefix';

    protected $cache;

    /**
     * Construct the RedisClear instance.
     *
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        parent::__construct();

        $this->cache = $cache;
    }

    /**
     * Delete the keys from REDIS which match the database.redis.options.prefix config value.
     */
    public function handle()
    {
        // Get the keys for the site
        $keys = $this->cache->getStore()->getRedis()->keys('*');
        foreach ((array) $keys as $key) {
            $this->cache->getStore()->getRedis()->del(preg_replace('/^'.config('database.redis.options.prefix').'/', '', $key));
        }
    }
}
