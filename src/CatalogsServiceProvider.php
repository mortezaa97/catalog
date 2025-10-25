<?php

namespace Mortezaa97\Catalogs;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mortezaa97\Catalogs\Models\Catalog;
use Mortezaa97\Catalogs\Policies\CatalogPolicy;
use Mortezaa97\Catalogs\Models\ModelHasCatalog;
use Mortezaa97\Catalogs\Policies\ModelHasCatalogPolicy;

class CatalogsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        Gate::policy(Catalog::class, CatalogPolicy::class);
        Gate::policy(ModelHasCatalog::class, ModelHasCatalogPolicy::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('catalogs.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'catalogs');

        // Register the main class to use with the facade
        $this->app->singleton('catalogs', function () {
            return new Catalogs;
        });
    }
}
