<?php

namespace Midnite81\LaravelBase;

use Illuminate\Support\ServiceProvider;
use Midnite81\LaravelBase\Commands\BackupDatabase;
use Midnite81\LaravelBase\Commands\ChangeEnvVariable;
use Midnite81\LaravelBase\Commands\GetEnvVariable;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            GetEnvVariable::class,
            ChangeEnvVariable::class,
            BackupDatabase::class,
        ]);
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
