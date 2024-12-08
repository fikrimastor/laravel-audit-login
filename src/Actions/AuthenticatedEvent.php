<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\AuthenticatedEventContract;

class AuthenticatedEvent extends BaseEvent implements AuthenticatedEventContract
{

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->event = $event;
        $this->attributes = $attributes;
        $this->execute();
    }
}
