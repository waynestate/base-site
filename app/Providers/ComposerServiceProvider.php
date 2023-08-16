<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot(Request $request): void
    {
        View::composer('errors::404', function ($view) use ($request) {
            $view->with('request', $request);
        });
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //
    }
}
