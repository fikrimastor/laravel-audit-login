<?php

namespace FikriMastor\AuditLogin\Actions;

use FikriMastor\AuditLogin\Actions\BaseEvent;
use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Contracts\PasswordResetLinkSentEventContract;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;

class PasswordResetLinkSentEvent extends BaseEvent implements PasswordResetLinkSentEventContract
{
    protected EventTypeEnum $eventType = EventTypeEnum::PASSWORD_RESET_LINK_SENT;

    public function handle(object $event, AuditLoginAttribute $attributes): void
    {
        $this->attributes = $attributes->toArray();
        $this->event = $event;
        $this->execute();
    }
}