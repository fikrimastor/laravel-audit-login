<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use FikriMastor\AuditLogin\AuditLogin;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class BaseEvent
{
    protected EventTypeEnum $eventType;

    protected array $attributes = [];

    protected ?Authenticatable $user = null;

    /**
     * Execute the audit action.
     */
    protected function execute(): void
    {
        $this->attributes['event'] = $this->eventType;
        AuditLogin::auditEvent($this->attributes, $this->user);
    }
}
