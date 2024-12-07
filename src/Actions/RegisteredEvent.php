<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Registered;

class RegisteredEvent extends BaseEvent implements RegisteredEventContract
{

    public function handle(Registered $event, array $attributes): void
    {
        $this->eventType = EventTypeEnum::REGISTER;
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}