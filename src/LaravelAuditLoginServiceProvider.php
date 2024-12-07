<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Actions\{FailedLoginEvent, LoginEvent, LogoutEvent, PasswordResetEvent, RegisteredEvent};
use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;
use FikriMastor\LaravelAuditLogin\Listeners\AuditLoginSubscriber;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use FikriMastor\LaravelAuditLogin\Facades\LaravelAuditLogin;

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

        LaravelAuditLogin::recordRegisteredUsing(RegisteredEvent::class);
        LaravelAuditLogin::recordLoginUsing(LoginEvent::class);
        LaravelAuditLogin::recordFailedLoginUsing(FailedLoginEvent::class);
        LaravelAuditLogin::recordLogoutUsing(LogoutEvent::class);
        LaravelAuditLogin::recordForgotPasswordUsing(PasswordResetEvent::class);

        Event::subscribe(AuditLoginSubscriber::class);
    }
}
