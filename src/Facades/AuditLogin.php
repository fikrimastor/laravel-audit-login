<?php

namespace FikriMastor\AuditLogin\Facades;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool allowedLog(EventTypeEnum|null $event)
 * @method static void auditEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditLoginEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditFailedLoginEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditLockoutEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditAttemptingEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditAuthenticatedEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditLogoutEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditOtherDeviceLogoutEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditCurrentDeviceLogoutEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditRegisteredEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditValidatedEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditVerifiedEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditPasswordResetEvent(object $event, AuditLoginAttribute $attributes)
 * @method static void auditPasswordResetLinkSentEvent(object $event, AuditLoginAttribute $attributes)
 *
 * @see \FikriMastor\AuditLogin\AuditLogin
 */
class AuditLogin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FikriMastor\AuditLogin\AuditLogin::class;
    }
}
