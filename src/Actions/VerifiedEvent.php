<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\VerifiedEventContract;

class VerifiedEvent extends BaseEvent implements VerifiedEventContract
{

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->event = $event;
        $this->attributes = $attributes;
        $this->execute();
    }
}
