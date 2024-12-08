<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Contracts\LoginEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Login;

class LoginEvent extends BaseEvent implements LoginEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::LOGIN;

    public function handle(Login $event, array $attributes): void
    {
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
