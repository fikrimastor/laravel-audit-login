<?php

namespace FikriMastor\LaravelAuditLogin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;

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
            ->hasMigration('create_laravel_audit_login_table')
            ->hasCommand(LaravelAuditLoginCommand::class);
    }
}
