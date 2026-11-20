<?php

namespace Abolaradev\LivewireRateLimiter;

use Illuminate\Support\ServiceProvider;

class LivewireRateLimiterServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-rate-limiter.php',
            'livewire-rate-limiter'
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
            __DIR__.'/../config/livewire-rate-limiter.php' => config_path('livewire-rate-limiter.php'),
        ], ['livewire-rate-limiter', 'livewire-rate-limiter-config']);

    }
}
