<?php

namespace FikriMastor\AuditLogin;

use FikriMastor\AuditLogin\Actions\FailedLoginEvent;
use FikriMastor\AuditLogin\Actions\LoginEvent;
use FikriMastor\AuditLogin\Actions\LogoutEvent;
use FikriMastor\AuditLogin\Actions\PasswordResetEvent;
use FikriMastor\AuditLogin\Actions\RegisteredEvent;
use FikriMastor\AuditLogin\Facades\AuditLogin;
use FikriMastor\AuditLogin\Listeners\AuditLoginSubscriber;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AuditLoginServiceProvider extends PackageServiceProvider
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
            ->hasMigration('create_audit_logins_table');
    }

    public function boot(): void
    {
        parent::boot();

        AuditLogin::recordRegisteredUsing(RegisteredEvent::class);
        AuditLogin::recordLoginUsing(LoginEvent::class);
        AuditLogin::recordFailedLoginUsing(FailedLoginEvent::class);
        AuditLogin::recordLogoutUsing(LogoutEvent::class);
        AuditLogin::recordForgotPasswordUsing(PasswordResetEvent::class);

        Event::subscribe(AuditLoginSubscriber::class);
    }
}
