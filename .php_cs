<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/contracts')
    ->in(__DIR__ . '/factories')
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/styleguide')
    ->in(__DIR__ . '/tests');

$fixers = [
    '@PSR2' => true,
];

return Config::create()
    ->setFinder($finder)
    ->setRules($fixers)
    ->setUsingCache(true);
