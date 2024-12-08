<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\AttemptingEventContract;

class AttemptingEvent extends BaseEvent implements AttemptingEventContract
{

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->event = $event;
        $this->attributes = $attributes;
        $this->execute();
    }
}
