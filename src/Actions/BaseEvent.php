<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLogin;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class BaseEvent
{
    protected AuditLoginAttribute $attributes;

    protected ?Authenticatable $user = null;

    protected object $event;

    /**
     * Execute the audit action.
     */
    protected function execute(): void
    {
        AuditLogin::auditEvent($this->event, $this->attributes);
    }
}
