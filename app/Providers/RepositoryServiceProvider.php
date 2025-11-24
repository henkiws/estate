<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AgencyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind AgencyRepository
        $this->app->singleton(AgencyRepository::class, function ($app) {
            return new AgencyRepository();
        });

        // Add more repository bindings here as needed
        // Example:
        // $this->app->singleton(PropertyRepository::class, function ($app) {
        //     return new PropertyRepository();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}