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
//    protected $loginEventContract;
//    protected $logoutEventContract;
//    protected $failedLoginEventContract;
//    protected $passwordResetEventContract;
//    protected $registeredEventContract;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
//        private readonly LoginEventContract $loginEventContract,
//        private readonly LogoutEventContract $logoutEventContract,
//        private readonly FailedLoginEventContract $failedLoginEventContract,
//        private readonly PasswordResetEventContract $passwordResetEventContract,
//        private readonly RegisteredEventContract $registeredEventContract
    ) {

        $this->attributes = [
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }

    /**
     * Handle the event.
     */
    public function handleLoginEventLog(Login $event): void
    {
        $this->loginEventContract->handle($event, $this->attributes);
    }

    public function handleFailedEventLog(Failed $event): void
    {
        $this->failedLoginEventContract->handle($event, $this->attributes);
    }

    public function handlePasswordResetEventLog(PasswordReset $event): void
    {
        $this->passwordResetEventContract->handle($event, $this->attributes);
    }

    public function handleRegisteredEventLog(Registered $event): void
    {
        $this->registeredEventContract->handle($event, $this->attributes);
    }

    public function handleLogoutEventLog(Logout $event): void
    {
        $this->logoutEventContract->handle($event, $this->attributes);
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
