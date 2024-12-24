# Audit Login with Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fikrimastor/audit-login.svg?style=flat-square)](https://packagist.org/packages/fikrimastor/audit-login)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fikrimastor/audit-login/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fikrimastor/audit-login/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fikrimastor/audit-login/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fikrimastor/audit-login/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fikrimastor/audit-login.svg?style=flat-square)](https://packagist.org/packages/fikrimastor/audit-login)

Audit login is another package for [Laravel](https://laravel.com/) framework. The purpose is auditing login events

## Support us

## Installation

You can install the package via composer:

```bash
composer require fikrimastor/audit-login
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="audit-login-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="audit-login-config"
```

This is the contents of the published config file:

```php
return [
    'enabled' => env('AUDIT_LOGIN_ENABLED', true),
    'drivers' => [
        'database' => [
            'table' => env('AUDIT_LOGIN_DATABASE_TABLE', 'audit-logins'),
            'connection' => env('AUDIT_LOGIN_DATABASE_CONNECTION', 'mysql'),
        ],
    ],
    ...
];
```

## Usage

If you want to custom some actions, for example, while user login, you want to send an email notification, you may create new service provider and defined it in config/app.php.

So, under the new service provider, under the boot method, you can do something like this:
```php
use \FikriMastor\AuditLogin\Facades\AuditLogin;
use \YourProjectNamespace\YourCustomLoginEventClass;

public function boot(): void
{
    AuditLogin::recordLoginUsing(YourCustomLoginEventClass::class);
}

```

And then, you can create a new class for your custom login event action class, for example:
```php
use \FikriMastor\AuditLogin\Contracts\LoginEventContract;

class YourCustomLoginEventClass implements LoginEventContract
{
    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        AuditLogin::auditEvent($event, $attributes);
        
        // Do something here
        
        // Send email notification
        
        
    }
}
````

The event object consists of the user object logged in,
and the attribute object is the object that contains the login event attributes.

Some of it use Authenticatable contract, so you can use it to get the user data.

You may learn about Auth events in Laravel [here](https://laravel.com/api/11.x/Illuminate/Auth/Events.html).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Fikri Mastor](https://github.com/fikrimastor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
