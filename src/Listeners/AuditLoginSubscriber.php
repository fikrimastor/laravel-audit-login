<?php

namespace FikriMastor\AuditLogin\Listeners;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\{AttemptingEventContract,
    AuthenticatedEventContract,
    CurrentDeviceLogoutEventContract,
    FailedLoginEventContract,
    LockoutEventContract,
    LoginEventContract,
    LogoutEventContract,
    OtherDeviceLogoutEventContract,
    PasswordResetEventContract,
    PasswordResetLinkSentEventContract,
    RegisteredEventContract,
    ValidatedEventContract,
    VerifiedEventContract};
use Illuminate\Auth\Events\{Attempting,
    Authenticated,
    CurrentDeviceLogout,
    Failed,
    Lockout,
    Login,
    Logout,
    OtherDeviceLogout,
    PasswordReset,
    PasswordResetLinkSent,
    Registered,
    Validated,
    Verified};
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class AuditLoginSubscriber
{
    public AuditLoginAttribute $auditLoginAttribute;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(public Request $request)
    {
        $this->auditLoginAttribute = new AuditLoginAttribute($this->request);
    }

    /**
     * Handle the login event.
     *
     * @throws \Exception
     */
    public function handleLoginEventLog(object $event): void
    {
        if (config('audit-login.events.login.enabled', true) === false) {
            return;
        }

        resolve(LoginEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the failed login event.
     *
     * @throws \Exception
     */
    public function handleFailedEventLog(object $event): void
    {
        if (config('audit-login.events.failed_login.enabled', true) === false) {
            return;
        }

        resolve(FailedLoginEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the password reset event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetEventLog(object $event): void
    {
        if (config('audit-login.events.password_reset.enabled', true) === false) {
            return;
        }

        resolve(PasswordResetEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the registered event.
     *
     * @throws \Exception
     */
    public function handleRegisteredEventLog(object $event): void
    {
        if (config('audit-login.events.registered.enabled', true) === false) {
            return;
        }

        resolve(RegisteredEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the logout event.
     *
     * @throws \Exception
     */
    public function handleLogoutEventLog(object $event): void
    {
        if (config('audit-login.events.logout.enabled', true) === false) {
            return;
        }

        resolve(LogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the attempting event.
     *
     * @throws \Exception
     */
    public function handleAttemptingEventLog(object $event): void
    {
        if (config('audit-login.events.attempting.enabled', true) === false) {
            return;
        }

        resolve(AttemptingEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the authenticated event.
     *
     * @throws \Exception
     */
    public function handleAuthenticatedEventLog(object $event): void
    {
        if (config('audit-login.events.authenticated.enabled', true) === false) {
            return;
        }

        resolve(AuthenticatedEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the current device logout event.
     *
     * @throws \Exception
     */
    public function handleCurrentDeviceLogoutEventLog(object $event): void
    {
        if (config('audit-login.events.current_device_logout.enabled', true) === false) {
            return;
        }

        resolve(CurrentDeviceLogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the current device logout event.
     *
     * @throws \Exception
     */
    public function handleLockoutEventLog(object $event): void
    {
        if (config('audit-login.events.lockout.enabled', true) === false) {
            return;
        }

        resolve(LockoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the other device logout event.
     *
     * @throws \Exception
     */
    public function handleOtherDeviceLogoutEventLog(object $event): void
    {
        if (config('audit-login.events.other_device_logout.enabled', true) === false) {
            return;
        }

        resolve(OtherDeviceLogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the password reset link sent event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetLinkSentEventLog(object $event): void
    {
        if (config('audit-login.events.password_reset_link_sent.enabled', true) === false) {
            return;
        }

        resolve(PasswordResetLinkSentEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the validated event.
     *
     * @throws \Exception
     */
    public function handleValidatedEventLog(object $event): void
    {
        if (config('audit-login.events.validated.enabled', true) === false) {
            return;
        }

        resolve(ValidatedEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the verified event.
     *
     * @throws \Exception
     */
    public function handleVerifiedEventLog(object $event): void
    {
        if (config('audit-login.events.verified.enabled', true) === false) {
            return;
        }

        resolve(VerifiedEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            config('audit-login.events.login.class', Login::class) => 'handleLoginEventLog',
            config('audit-login.events.logout.class', Logout::class) => 'handleLogoutEventLog',
            config('audit-login.events.password_reset.class', PasswordReset::class) => 'handlePasswordResetEventLog',
            config('audit-login.events.failed_login.class', Failed::class) => 'handleFailedEventLog',
            config('audit-login.events.registered.class', Registered::class) => 'handleRegisteredEventLog',
            config('audit-login.events.attempting.class', Attempting::class) => 'handleAttemptingEventLog',
            config('audit-login.events.authenticated.class', Authenticated::class) => 'handleAuthenticatedEventLog',
            config('audit-login.events.current_device_logout.class', CurrentDeviceLogout::class) => 'handleCurrentDeviceLogoutEventLog',
            config('audit-login.events.lockout.class', Lockout::class) => 'handleLockoutEventLog',
            config('audit-login.events.other_device_logout.class', OtherDeviceLogout::class) => 'handleOtherDeviceLogoutEventLog',
            config('audit-login.events.password_reset_link_sent.class', PasswordResetLinkSent::class) => 'handlePasswordResetLinkSentEventLog',
            config('audit-login.events.validated.class', Validated::class) => 'handleValidatedEventLog',
            config('audit-login.events.verified.class', Verified::class) => 'handleVerifiedEventLog',
        ];
    }
}
