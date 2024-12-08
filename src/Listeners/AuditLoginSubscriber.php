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
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
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

        $this->auditLoginAttribute->eventType(EventTypeEnum::LOGIN);

        resolve(LoginEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the failed login event.
     *
     * @throws \Exception
     */
    public function handleFailedEventLog(object $event): void
    {
        if (config('audit-login.events.failed-login.enabled', true) === false) {
            return;
        }

        $this->auditLoginAttribute->eventType(EventTypeEnum::FAILED_LOGIN);

        resolve(FailedLoginEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the password reset event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetEventLog(object $event): void
    {
        if (config('audit-login.events.password-reset.enabled', true) === false) {
            return;
        }

        $this->auditLoginAttribute->eventType(EventTypeEnum::RESET_PASSWORD);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::REGISTER);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::LOGOUT);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::ATTEMPTING);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::AUTHENTICATED);

        resolve(AuthenticatedEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the current device logout event.
     *
     * @throws \Exception
     */
    public function handleCurrentDeviceLogoutEventLog(object $event): void
    {
        if (config('audit-login.events.current-device-logout.enabled', true) === false) {
            return;
        }

        $this->auditLoginAttribute->eventType(EventTypeEnum::CURRENT_DEVICE_LOGOUT);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::LOCKOUT);

        resolve(LockoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the other device logout event.
     *
     * @throws \Exception
     */
    public function handleOtherDeviceLogoutEventLog(object $event): void
    {
        if (config('audit-login.events.other-device-logout.enabled', true) === false) {
            return;
        }

        $this->auditLoginAttribute->eventType(EventTypeEnum::OTHER_DEVICE_LOGOUT);

        resolve(OtherDeviceLogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
    }

    /**
     * Handle the password reset link sent event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetLinkSentEventLog(object $event): void
    {
        if (config('audit-login.events.password-reset-link-sent.enabled', true) === false) {
            return;
        }

        $this->auditLoginAttribute->eventType(EventTypeEnum::PASSWORD_RESET_LINK_SENT);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::VALIDATED);

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

        $this->auditLoginAttribute->eventType(EventTypeEnum::VERIFIED);

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
            config('audit-login.events.password-reset.class', PasswordReset::class) => 'handlePasswordResetEventLog',
            config('audit-login.events.failed-login.class', Failed::class) => 'handleFailedEventLog',
            config('audit-login.events.registered.class', Registered::class) => 'handleRegisteredEventLog',
            config('audit-login.events.attempting.class', Attempting::class) => 'handleAttemptingEventLog',
            config('audit-login.events.authenticated.class', Authenticated::class) => 'handleAuthenticatedEventLog',
            config('audit-login.events.current-device-logout.class', CurrentDeviceLogout::class) => 'handleCurrentDeviceLogoutEventLog',
            config('audit-login.events.lockout.class', Lockout::class) => 'handleLockoutEventLog',
            config('audit-login.events.other-device-logout.class', OtherDeviceLogout::class) => 'handleOtherDeviceLogoutEventLog',
            config('audit-login.events.password-reset-link-sent.class', PasswordResetLinkSent::class) => 'handlePasswordResetLinkSentEventLog',
            config('audit-login.events.validated.class', Validated::class) => 'handleValidatedEventLog',
            config('audit-login.events.verified.class', Verified::class) => 'handleVerifiedEventLog',
        ];
    }
}
