<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Contracts\RegisteredEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Registered;

class RegisteredEvent extends BaseEvent implements RegisteredEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::REGISTER;

    public function handle(Registered $event, array $attributes): void
    {
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
