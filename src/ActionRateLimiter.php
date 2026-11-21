<?php

namespace Abolaradev\ActionRateLimiter;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ActionRateLimiter
{
    /**
     * Maximum number of allowed attempts.
     */
    private int $maxAttempts;

    /**
     * Rate limit decay duration in seconds.
     */
    private int $decaySeconds;

    /**
     * Unique key used to identify the rate limit bucket.
     */
    private string $key;

    /**
     * Create a new rate limiter instance.
     */
    public function __construct()
    {
        $this->maxAttempts = config('action-rate-limiter.max_attempts');
        $this->decaySeconds = config('action-rate-limiter.decay_seconds');
        $this->key = $this->generateKey();
    }

    /**
     * Set the maximum number of allowed attempts.
     */
    public function maxAttempts(int $maxAttempts): static
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    /**
     * Set the rate limit decay duration in seconds.
     */
    public function decaySeconds(int $decaySeconds): static
    {
        $this->decaySeconds = $decaySeconds;

        return $this;
    }

    /**
     * Set a custom rate limit key.
     */
    public function key(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Execute the callback if the rate limit has not been exceeded.
     *
     * @throws TooManyRequestsHttpException
     */
    public function attempt(Closure $callable): void
    {
        $execute = RateLimiter::attempt(
            key: $this->key,
            maxAttempts: $this->maxAttempts,
            callback: $callable,
            decaySeconds: $this->decaySeconds
        );

        if (! $execute) {
            throw new TooManyRequestsHttpException(
                message: 'Too Many Requests!'
            );
        }
    }

    /**
     * Get the number of seconds until the rate limit resets.
     */
    public function availableIn(): int
    {
        return RateLimiter::availableIn($this->key);
    }

    /**
     * Get the number of remaining allowed attempts.
     */
    public function remaining(): int
    {
        return RateLimiter::remaining($this->key, $this->maxAttempts);
    }

    /**
     * Get the number of attempts made for the current key.
     */
    public function attempts(): int
    {
        return RateLimiter::attempts($this->key);
    }

    /**
     * Generate a unique rate limit key based on the user's identity and IP address.
     */
    private function generateKey(): string
    {
        $identifier = Auth::check()
            ? 'user:' . Auth::id()
            : 'guest';

        $ip = Request::ip() ?? 'unknown';

        return hash('sha256', implode('|', [
            'action-rate-limiter',
            $ip,
            $identifier,
        ]));
    }
}
