<?php

namespace App\Providers;

use App\Http\Helpers\TimingHelper;
use Illuminate\Support\ServiceProvider;

class TimingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('timing',function (){

            return new TimingHelper();

        });
    }

    public function provides()
    {
        return ['timing'];
    }
}
