<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class FailedLoginEvent extends BaseEvent implements FailedLoginEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::FAILED_LOGIN;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}
