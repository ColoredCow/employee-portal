<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DomainService;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(DomainService::class, function ($app) {
            return new DomainService;
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
