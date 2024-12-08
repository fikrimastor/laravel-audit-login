<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Actions\BaseEvent;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\OtherDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class OtherDeviceLogoutEvent extends BaseEvent implements OtherDeviceLogoutEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::OTHER_DEVICE_LOGOUT;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}