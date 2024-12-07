<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;
use FikriMastor\LaravelAuditLogin\Listeners\AuditLoginSubscriber;
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

        Event::subscribe(AuditLoginSubscriber::class);
    }
}
