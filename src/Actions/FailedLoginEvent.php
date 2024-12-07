<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
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
