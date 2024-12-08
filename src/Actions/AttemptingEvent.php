<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Actions\BaseEvent;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\AttemptingEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class AttemptingEvent extends BaseEvent implements AttemptingEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::ATTEMPTING;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}