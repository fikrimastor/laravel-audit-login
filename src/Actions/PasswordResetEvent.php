<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\PasswordResetEventContract;

class PasswordResetEvent extends BaseEvent implements PasswordResetEventContract
{
    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->event = $event;
        $this->attributes = $attributes;
        $this->execute();
    }
}
