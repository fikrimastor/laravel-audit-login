<?php

namespace FikriMastor\AuditLogin\Listeners;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\AttemptingEventContract;
use FikriMastor\AuditLogin\Contracts\AuthenticatedEventContract;
use FikriMastor\AuditLogin\Contracts\CurrentDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\AuditLogin\Contracts\LockoutEventContract;
use FikriMastor\AuditLogin\Contracts\LoginEventContract;
use FikriMastor\AuditLogin\Contracts\LogoutEventContract;
use FikriMastor\AuditLogin\Contracts\OtherDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\AuditLogin\Contracts\PasswordResetLinkSentEventContract;
use FikriMastor\AuditLogin\Contracts\RegisteredEventContract;
use FikriMastor\AuditLogin\Contracts\ValidatedEventContract;
use FikriMastor\AuditLogin\Contracts\VerifiedEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use FikriMastor\AuditLogin\Facades\AuditLogin;
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
        $this->auditLoginAttribute = new AuditLoginAttribute($request);
    }

    /**
     * Handle the login event.
     *
     * @throws \Exception
     */
    public function handleLoginEventLog(object $event): void
    {
        $eventType = EventTypeEnum::LOGIN;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(LoginEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the failed login event.
     *
     * @throws \Exception
     */
    public function handleFailedEventLog(object $event): void
    {
        $eventType = EventTypeEnum::FAILED_LOGIN;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(FailedLoginEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the password reset event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetEventLog(object $event): void
    {
        $eventType = EventTypeEnum::RESET_PASSWORD;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(PasswordResetEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the registered event.
     *
     * @throws \Exception
     */
    public function handleRegisteredEventLog(object $event): void
    {
        $eventType = EventTypeEnum::REGISTER;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(RegisteredEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the logout event.
     *
     * @throws \Exception
     */
    public function handleLogoutEventLog(object $event): void
    {
        $eventType = EventTypeEnum::LOGOUT;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(LogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the attempting event.
     *
     * @throws \Exception
     */
    public function handleAttemptingEventLog(object $event): void
    {
        $eventType = EventTypeEnum::ATTEMPTING;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(AttemptingEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the authenticated event.
     *
     * @throws \Exception
     */
    public function handleAuthenticatedEventLog(object $event): void
    {
        $eventType = EventTypeEnum::AUTHENTICATED;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(AuthenticatedEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the current device logout event.
     *
     * @throws \Exception
     */
    public function handleCurrentDeviceLogoutEventLog(object $event): void
    {
        $eventType = EventTypeEnum::CURRENT_DEVICE_LOGOUT;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(CurrentDeviceLogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the current device logout event.
     *
     * @throws \Exception
     */
    public function handleLockoutEventLog(object $event): void
    {
        $eventType = EventTypeEnum::LOCKOUT;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(LockoutEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the other device logout event.
     *
     * @throws \Exception
     */
    public function handleOtherDeviceLogoutEventLog(object $event): void
    {
        $eventType = EventTypeEnum::OTHER_DEVICE_LOGOUT;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(OtherDeviceLogoutEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the password reset link sent event.
     *
     * @throws \Exception
     */
    public function handlePasswordResetLinkSentEventLog(object $event): void
    {
        $eventType = EventTypeEnum::PASSWORD_RESET_LINK_SENT;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(PasswordResetLinkSentEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the validated event.
     *
     * @throws \Exception
     */
    public function handleValidatedEventLog(object $event): void
    {
        $eventType = EventTypeEnum::VALIDATED;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(ValidatedEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Handle the verified event.
     *
     * @throws \Exception
     */
    public function handleVerifiedEventLog(object $event): void
    {
        $eventType = EventTypeEnum::VERIFIED;
        if (AuditLogin::allowedLog($eventType)) {
            $this->auditLoginAttribute->eventType($eventType);

            resolve(VerifiedEventContract::class)->handle($event, $this->auditLoginAttribute);
        }
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            AuditLogin::getEventClass(EventTypeEnum::LOGIN) => 'handleLoginEventLog',
            AuditLogin::getEventClass(EventTypeEnum::LOGOUT) => 'handleLogoutEventLog',
            AuditLogin::getEventClass(EventTypeEnum::RESET_PASSWORD) => 'handlePasswordResetEventLog',
            AuditLogin::getEventClass(EventTypeEnum::FAILED_LOGIN) => 'handleFailedEventLog',
            AuditLogin::getEventClass(EventTypeEnum::REGISTER) => 'handleRegisteredEventLog',
            AuditLogin::getEventClass(EventTypeEnum::ATTEMPTING) => 'handleAttemptingEventLog',
            AuditLogin::getEventClass(EventTypeEnum::AUTHENTICATED) => 'handleAuthenticatedEventLog',
            AuditLogin::getEventClass(EventTypeEnum::CURRENT_DEVICE_LOGOUT) => 'handleCurrentDeviceLogoutEventLog',
            AuditLogin::getEventClass(EventTypeEnum::LOGOUT) => 'handleLockoutEventLog',
            AuditLogin::getEventClass(EventTypeEnum::OTHER_DEVICE_LOGOUT) => 'handleOtherDeviceLogoutEventLog',
            AuditLogin::getEventClass(EventTypeEnum::PASSWORD_RESET_LINK_SENT) => 'handlePasswordResetLinkSentEventLog',
            AuditLogin::getEventClass(EventTypeEnum::VALIDATED) => 'handleValidatedEventLog',
            AuditLogin::getEventClass(EventTypeEnum::VERIFIED) => 'handleVerifiedEventLog',
        ];
    }
}
