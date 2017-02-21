<?php
namespace Midnite81\LaravelBase;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once($filename);
        }
    }
}