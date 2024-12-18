<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLogin;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\ValidatedEventContract;

class ValidatedEvent implements ValidatedEventContract
{
    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        AuditLogin::auditEvent($event, $attributes);

        /** Another task like sending emails */
    }
}
