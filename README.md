# Action Rate Limiter

Action Rate Limiter is a lightweight Laravel package built on top of Laravel's native Rate Limiter. It allows you to control the execution of application actions using configurable attempt limits and decay durations.

## Installation

Install the package via Composer:

```bash
composer require abolaradev/action-rate-limiter
```

## Configuration

Publish the package configuration file:

```bash
php artisan vendor:publish --tag='action-rate-limiter-config'
```

This will publish the configuration file to `config/action-rate-limiter.php`, where you can define the default maximum attempts and decay duration.

## Usage

You can use the `ActionRateLimiter` facade to control how many times an action can be executed within a specified time period.

### Using try/catch

```php
use Abolaradev\ActionRateLimiter\Facades\ActionRateLimiter;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

public function store()
{
    try {
        ActionRateLimiter::maxAttempts(5)
            ->decaySeconds(60)
            ->attempt(function () {
                // Your action logic...
            });

    } catch (TooManyRequestsHttpException $e) {
        // Handle rate limit exceeded...
    }
}
```

In this example, the action can be executed up to 5 times within 60 seconds. Further attempts will throw a `TooManyRequestsHttpException`.

### Using the Helper Function

Alternatively, you can use the `action_rate_limiter()` helper function instead of the `ActionRateLimiter` facade:

```php
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

public function store()
{
    try {
        action_rate_limiter()
            ->maxAttempts(5)
            ->decaySeconds(60)
            ->attempt(function () {
                // Your action logic...
            });

    } catch (TooManyRequestsHttpException $e) {
        // Handle rate limit exceeded...
    }
}
```

Both approaches provide the same functionality. Choose whichever style you prefer.

## Available Methods

The following methods are available on the `ActionRateLimiter` instance:

| Method | Description |
|---|---|
| `maxAttempts(int $maxAttempts)` | Sets the maximum number of allowed attempts. |
| `decaySeconds(int $decaySeconds)` | Sets the rate limit decay duration in seconds. |
| `key(string $key)` | Sets a custom key to identify the rate limit bucket. |
| `attempt(Closure $callable)` | Executes the callback if the rate limit has not been exceeded. Throws a `TooManyRequestsHttpException` otherwise. |
| `availableIn()` | Returns the number of seconds until the rate limit resets. |
| `remaining()` | Returns the number of remaining allowed attempts. |
| `attempts()` | Returns the number of attempts made for the current key. |






If you find this package useful, please don't forget to give it a ⭐ on GitHub. ❤️

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) for information on how to report security vulnerabilities.

## Credits

* [abolaradev](https://github.com/abolaradev)

* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
