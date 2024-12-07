<?php

namespace FikriMastor\LaravelAuditLogin;

use Illuminate\Auth\Events\{Login, Failed, Registered, PasswordReset, Logout};
use FikriMastor\LaravelAuditLogin\Actions\{LoginEvent, LogoutEvent, FailedLoginEvent, PasswordResetEvent, RegisteredEvent};
use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;
use FikriMastor\LaravelAuditLogin\Listeners\{LoginListener, LogoutListener, FailedListener, PasswordResetListener, RegisteredListener};
use FikriMastor\LaravelAuditLogin\Contracts\{LoginEventContract, FailedLoginEventContract, LogoutEventContract, PasswordResetEventContract, RegisteredEventContract};
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAuditLoginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-audit-login')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_audit_logins_table')
            ->hasCommand(LaravelAuditLoginCommand::class);
    }

    public function boot(): void
    {
        parent::boot();

        $this->app->bind(LoginEventContract::class, LoginEvent::class);
        $this->app->bind(LogoutEventContract::class, LogoutEvent::class);
        $this->app->bind(FailedLoginEventContract::class, FailedLoginEvent::class);
        $this->app->bind(PasswordResetEventContract::class, PasswordResetEvent::class);
        $this->app->bind(RegisteredEventContract::class, RegisteredEvent::class);

        Event::listen(Login::class, LoginListener::class);
        Event::listen(Logout::class, LogoutListener::class);
        Event::listen(Failed::class, FailedListener::class);
        Event::listen(Registered::class, RegisteredListener::class);
        Event::listen(PasswordReset::class, PasswordResetListener::class);
    }
}
