<?php

namespace Abolaradev\RateLimiter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abolaradev\RateLimiter\RateLimiter
 */
class RateLimiter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abolaradev\RateLimiter\RateLimiter::class;
    }
}
