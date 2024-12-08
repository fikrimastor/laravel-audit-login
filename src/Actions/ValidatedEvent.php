<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Actions\BaseEvent;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\ValidatedEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class ValidatedEvent extends BaseEvent implements ValidatedEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::VALIDATED;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}