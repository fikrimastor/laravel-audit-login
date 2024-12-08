<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetEvent extends BaseEvent implements PasswordResetEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::RESET_PASSWORD;

    public function handle(PasswordReset $event, array $attributes): void
    {
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
