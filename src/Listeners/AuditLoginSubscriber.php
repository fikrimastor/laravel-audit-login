<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\LogoutEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;

class AuditLoginSubscriber implements ShouldQueue
{
    public array $attributes = [];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->attributes = [
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }

    /**
     * Handle the event.
     */
    public function handleLoginEventLog(Login $event, LoginEventContract $contract): void
    {
        $contract->handle($event, $this->attributes);
    }

    public function handleFailedEventLog(Failed $event, FailedLoginEventContract $contract): void
    {
        $contract->handle($event, $this->attributes);
    }

    public function handlePasswordResetEventLog(PasswordReset $event, PasswordResetEventContract $contract): void
    {
        $contract->handle($event, $this->attributes);
    }

    public function handleRegisteredEventLog(Registered $event, RegisteredEventContract $contract): void
    {
        $contract->handle($event, $this->attributes);
    }

    public function handleLogoutEventLog(Logout $event, LogoutEventContract $contract): void
    {
        $contract->handle($event, $this->attributes);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLoginEventLog',
            Logout::class => 'handleLogoutEventLog',
            PasswordReset::class => 'handlePasswordResetEventLog',
            Failed::class => 'handleFailedEventLog',
            Registered::class => 'handleRegisteredEventLog',
        ];
    }

    /**
     * Handle a job failure.
     */
    public function failed($event, $exception): void
    {
        report($exception);
    }
}
