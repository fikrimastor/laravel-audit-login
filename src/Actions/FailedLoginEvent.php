<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Failed;

class FailedLoginEvent extends BaseEvent implements FailedLoginEventContract
{

    public function handle(Failed $event, array $attributes): void
    {
        $this->eventType = EventTypeEnum::FAILED_LOGIN;
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}