<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\AuthenticatedEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class AuthenticatedEvent extends BaseEvent implements AuthenticatedEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::AUTHENTICATED;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}
