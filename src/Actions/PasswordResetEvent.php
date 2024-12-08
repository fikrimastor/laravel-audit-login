<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class PasswordResetEvent extends BaseEvent implements PasswordResetEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::RESET_PASSWORD;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}
