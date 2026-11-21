<?php

namespace Abolaradev\ActionRateLimiter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abolaradev\ActionRateLimiter\ActionRateLimiter
 */
class ActionRateLimiter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abolaradev\ActionRateLimiter\ActionRateLimiter::class;
    }
}
