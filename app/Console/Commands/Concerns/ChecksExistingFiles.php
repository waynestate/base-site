<?php

namespace App\Console\Commands\Concerns;

use Illuminate\Support\Facades\Storage;

trait ChecksExistingFiles
{
    /**
     * Whether any of the paths exist on the base disk, ignoring case like the styleguide page lookup.
     */
    protected function anyExists(array $paths): bool
    {
        return collect($paths)->contains(function ($path) {
            return collect(Storage::disk('base')->files(dirname($path)))
                ->contains(fn ($file) => strtolower($file) === strtolower($path));
        });
    }
}
