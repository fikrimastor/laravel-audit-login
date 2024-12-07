<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Login;

class LoginEvent extends BaseEvent implements LoginEventContract
{

    public function handle(Login $event, array $attributes): void
    {
        $this->eventType = EventTypeEnum::LOGIN;
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}