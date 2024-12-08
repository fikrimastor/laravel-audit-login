<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\VerifiedEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class VerifiedEvent extends BaseEvent implements VerifiedEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::VERIFIED;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}
