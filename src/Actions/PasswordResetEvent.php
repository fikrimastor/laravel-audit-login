<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetEvent extends BaseEvent implements PasswordResetEventContract
{
    public function handle(PasswordReset $event, array $attributes): void
    {
        $this->eventType = EventTypeEnum::RESET_PASSWORD;
        $this->attributes = $attributes;
        $this->user = $event->user;
        $this->execute();
    }
}
