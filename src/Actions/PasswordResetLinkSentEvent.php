<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\PasswordResetLinkSentEventContract;

class PasswordResetLinkSentEvent extends BaseEvent implements PasswordResetLinkSentEventContract
{

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes;
        $this->event = $event;
        $this->execute();
    }
}
