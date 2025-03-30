<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register ConfigHelper alias
        $this->app->bind('config-helper', function () {
            return new \App\Helpers\ConfigHelper();
        });

        //
        Paginator::defaultView('vendor.pagination.default');

    }
}
