<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;
use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\LogoutEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract;
use FikriMastor\LaravelAuditLogin\Listeners\AuditLoginSubscriber;
use FikriMastor\LaravelAuditLogin\Listeners\FailedListener;
use FikriMastor\LaravelAuditLogin\Listeners\LoginListener;
use FikriMastor\LaravelAuditLogin\Listeners\LogoutListener;
use FikriMastor\LaravelAuditLogin\Listeners\PasswordResetListener;
use FikriMastor\LaravelAuditLogin\Listeners\RegisteredListener;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
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

        LaravelAuditLogin::recordRegisteredUsing(RegisteredEventContract::class);
        LaravelAuditLogin::recordLoginUsing(LoginEventContract::class);
        LaravelAuditLogin::recordFailedLoginUsing(FailedLoginEventContract::class);
        LaravelAuditLogin::recordLogoutUsing(LogoutEventContract::class);
        LaravelAuditLogin::recordForgotPasswordUsing(PasswordResetEventContract::class);

        Event::subscribe(new AuditLoginSubscriber([
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));
        //        Event::listen(Login::class, LoginListener::class);
        //        Event::listen(Logout::class, LogoutListener::class);
        //        Event::listen(Failed::class, FailedListener::class);
        //        Event::listen(Registered::class, RegisteredListener::class);
        //        Event::listen(PasswordReset::class, PasswordResetListener::class);
    }
}
