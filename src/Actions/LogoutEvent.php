<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\LogoutEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\Logout;

class LogoutEvent extends BaseEvent implements LogoutEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::LOGOUT;

    public function handle(Logout $event, array $attributes): void
    {
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
