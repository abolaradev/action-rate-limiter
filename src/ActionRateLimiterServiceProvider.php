<?php

namespace Abolaradev\ActionRateLimiter;

use Illuminate\Support\ServiceProvider;

class ActionRateLimiterServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/action-rate-limiter.php',
            'action-rate-limiter'
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
            __DIR__.'/../config/action-rate-limiter.php' => config_path('action-rate-limiter.php'),
        ], ['action-rate-limiter', 'action-rate-limiter-config']);

    }
}
