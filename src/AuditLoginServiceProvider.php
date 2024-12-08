<?php

namespace FikriMastor\AuditLogin;

use FikriMastor\AuditLogin\Actions\{AttemptingEvent,
    AuthenticatedEvent,
    CurrentDeviceLogoutEvent,
    FailedLoginEvent,
    LockoutEvent,
    LoginEvent,
    LogoutEvent,
    OtherDeviceLogoutEvent,
    PasswordResetEvent,
    PasswordResetLinkSentEvent,
    RegisteredEvent,
    ValidatedEvent,
    VerifiedEvent};
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
        AuditLogin::recordAttemptingUsing(AttemptingEvent::class);
        AuditLogin::recordAuthenticatedUsing(AuthenticatedEvent::class);
        AuditLogin::recordCurrentDeviceLogoutUsing(CurrentDeviceLogoutEvent::class);
        AuditLogin::recordLockoutUsing(LockoutEvent::class);
        AuditLogin::recordOtherDeviceLogoutUsing(OtherDeviceLogoutEvent::class);
        AuditLogin::recordPasswordResetLinkSentUsing(PasswordResetLinkSentEvent::class);
        AuditLogin::recordValidatedUsing(ValidatedEvent::class);
        AuditLogin::recordVerifiedUsing(VerifiedEvent::class);

        Event::subscribe(config('audit-login.subscriber', AuditLoginSubscriber::class));
    }
}
