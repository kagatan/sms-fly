<?php

namespace Kagatan\SmsFly;

use Illuminate\Support\ServiceProvider;

class SmsFlyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsFlyClient::class, function () {
            return new SmsFlyClient(config('services.sms-fly'));
        });
    }
}
