<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

class Bootstrap implements Extension
{
    /*
    |--------------------------------------------------------------------------
    | Bootstrap The Test Environment
    |--------------------------------------------------------------------------
    |
    | You may specify console commands that execute once before your test is
    | run. You are free to add your own additional commands or logic into
    | this file as needed in order to help your test suite run quicker.
    |
    */

    use CreatesApplication;

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $this->executeBeforeFirstTest();
    }

    public function executeBeforeFirstTest(): void
    {
        $console = $this->createApplication()->make(Kernel::class);

        $commands = [
            'config:cache',
            'event:cache',
        ];

        foreach ($commands as $command) {
            $console->call($command);
        }
    }

    public function executeAfterLastTest(): void
    {
        array_map('unlink', glob('bootstrap/cache/*.phpunit.php'));
    }
}
