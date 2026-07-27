<?php

namespace App\Providers;

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
        // Register domain-specific migration paths
        $this->loadMigrationsFrom([
            database_path('migrations/administration'),
            database_path('migrations/product_master'),
            database_path('migrations/business_partner'),
            database_path('migrations/procurement'),
            database_path('migrations/inventory'),
            database_path('migrations/manufacturing'),
            database_path('migrations/quality_control'),
            database_path('migrations/warehouse'),
            database_path('migrations/sales'),
            database_path('migrations/accounting'),
        ]);
    }
}
