<?php

namespace App\Support;

use Faker\Factory;
use Faker\Generator;

class FakerFactory extends Factory
{
    /**
     * Create a generator instance or return the shared application generator.
     *
     * @param string $locale
     */
    public static function create($locale = self::DEFAULT_LOCALE): Generator
    {
        return fake($locale);
    }
}
