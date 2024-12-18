<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLogin;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\FailedLoginEventContract;

class FailedLoginEvent implements FailedLoginEventContract
{
    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        AuditLogin::auditEvent($event, $attributes);

        /** Another task like sending emails */
    }
}
