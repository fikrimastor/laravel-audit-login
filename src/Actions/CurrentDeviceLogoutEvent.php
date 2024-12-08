<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Actions\BaseEvent;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\CurrentDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class CurrentDeviceLogoutEvent extends BaseEvent implements CurrentDeviceLogoutEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::CURRENT_DEVICE_LOGOUT;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}