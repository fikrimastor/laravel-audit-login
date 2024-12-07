<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
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
