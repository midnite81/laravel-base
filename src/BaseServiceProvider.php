<?php

namespace Midnite81\LaravelBase;

use Illuminate\Support\ServiceProvider;

use Midnite81\LaravelBase\Commands\BackupDatabase;
use Midnite81\LaravelBase\Commands\Routes\ListUrls;
use Midnite81\LaravelBase\Commands\Users\CreateUser;
use Midnite81\LaravelBase\Commands\Users\EditUser;
use Midnite81\LaravelBase\Commands\Users\ResetUsersPassword;
use Midnite81\LaravelBase\Contracts\Services\UuidGenerator;
use Midnite81\LaravelBase\Services\UuidGenerator as UuidGeneratorService;
use Midnite81\LaravelBase\Commands\ChangeEnvVariable;
use Midnite81\LaravelBase\Commands\GetEnvVariable;

class BaseServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-base.php' => config_path('laravel-base.php')
        ]);

        if (config('laravel-base.artisan-commands', true)) {
            $this->loadCommands();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-base.php', 'laravel-base');

        $this->app->bind(UuidGenerator::class, UuidGeneratorService::class);

    }

    /**
     * Load Commands
     */
    protected function loadCommands()
    {
        $this->commands([
            GetEnvVariable::class,
            ChangeEnvVariable::class,
            BackupDatabase::class,
            CreateUser::class,
            ResetUsersPassword::class,
            ListUrls::class,
        ]);
    }
}
