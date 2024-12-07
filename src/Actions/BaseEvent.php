<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use FikriMastor\LaravelAuditLogin\LaravelAuditLogin;
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
        LaravelAuditLogin::auditEvent($this->attributes, $this->user);
    }
}
