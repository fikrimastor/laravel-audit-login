<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Failed;

class FailedLoginEvent extends BaseEvent implements FailedLoginEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::FAILED_LOGIN;

    public function handle(Failed $event, array $attributes): void
    {
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
