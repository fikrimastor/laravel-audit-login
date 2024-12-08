<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\LockoutEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class LockoutEvent extends BaseEvent implements LockoutEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::LOCKOUT;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}
