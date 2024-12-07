<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Commands\LaravelAuditLoginCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
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

        $this->app->bind(
            \FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract::class,
            \FikriMastor\LaravelAuditLogin\Actions\LoginEvent::class
        );
        $this->app->bind(
            \FikriMastor\LaravelAuditLogin\Contracts\LogoutEventContract::class,
            \FikriMastor\LaravelAuditLogin\Actions\LogoutEvent::class
        );
        $this->app->bind(
            \FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract::class,
            \FikriMastor\LaravelAuditLogin\Actions\FailedLoginEvent::class
        );
        $this->app->bind(
            \FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract::class,
            \FikriMastor\LaravelAuditLogin\Actions\PasswordResetEvent::class
        );
        $this->app->bind(
            \FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract::class,
            \FikriMastor\LaravelAuditLogin\Actions\RegisteredEvent::class
        );

        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \FikriMastor\LaravelAuditLogin\Listeners\LoginListener::class
        );

        Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            \FikriMastor\LaravelAuditLogin\Listeners\LogoutListener::class
        );

        Event::listen(
            \Illuminate\Auth\Events\Failed::class,
            \FikriMastor\LaravelAuditLogin\Listeners\FailedListener::class
        );

        Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            \FikriMastor\LaravelAuditLogin\Listeners\RegisteredListener::class
        );
    }

    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__.'/../config/audit-login.php' => config_path('audit-login.php'),
        ], 'audit-login-config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_audit_logins_table.php.stub' => $this->getMigrationFileName('create_audit_logins_table.php'),
        ], 'audit-login-migrations');
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR])
            ->flatMap(fn ($path) => $filesystem->glob($path.'*_'.$migrationFileName))
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
