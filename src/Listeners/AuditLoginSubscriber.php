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
use Illuminate\Events\Dispatcher;

class AuditLoginSubscriber
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
     * Handle the login event.
     *
     * @throws \Exception
     */
    public function handleLoginEventLog(Login $event): void
    {
        resolve(LoginEventContract::class)->handle($event, $this->attributes);
    }

    /**
     * Handle the failed login event.
     *
     * @throws \Exception
     */
    public function handleFailedEventLog(Failed $event): void
    {
        resolve(FailedLoginEventContract::class)->handle($event, $this->attributes);
    }

    /**
     * Handle the password reset event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetEventLog(PasswordReset $event): void
    {
        resolve(PasswordResetEventContract::class)->handle($event, $this->attributes);
    }

    /**
     * Handle the registered event.
     *
     * @throws \Exception
     */
    public function handleRegisteredEventLog(Registered $event): void
    {
        resolve(RegisteredEventContract::class)->handle($event, $this->attributes);
    }

    /**
     * Handle the logout event.
     *
     * @throws \Exception
     */
    public function handleLogoutEventLog(Logout $event): void
    {
        resolve(LogoutEventContract::class)->handle($event, $this->attributes);
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
