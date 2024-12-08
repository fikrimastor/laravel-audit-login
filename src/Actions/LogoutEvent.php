<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Contracts\LogoutEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
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
