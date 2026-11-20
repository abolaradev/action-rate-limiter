<?php

namespace Abolaradev\RateLimiter;

use Illuminate\Support\ServiceProvider;

class RateLimiterServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/rate-limiter.php',
            'rate-limiter'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish the package configuration file
        $this->publishes([
            __DIR__.'/../config/rate-limiter.php' => config_path('rate-limiter.php'),
        ], ['rate-limiter', 'rate-limiter-config']);

    }
}
