<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\{FailedLoginEventContract, LoginEventContract, LogoutEventContract, PasswordResetEventContract, RegisteredEventContract};
use Illuminate\Auth\Events\{Failed, Login, Logout, PasswordReset, Registered};
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
            'url'            => request()->fullUrl(),
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ];
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @param  LoginEventContract  $contract
     * @return void
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
     *
     * @param  Dispatcher  $events
     * @return array
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
     *
     * @param $event
     * @param $exception
     * @return void
     */
    public function failed($event, $exception): void
    {
        report($exception);
    }
}