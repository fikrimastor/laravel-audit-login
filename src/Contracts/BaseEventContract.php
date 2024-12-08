<?php

namespace FikriMastor\AuditLogin\Contracts;

use FikriMastor\AuditLogin\AuditLoginAttribute;

interface BaseEventContract
{
    public function handle(object $event, AuditLoginAttribute $attributes): void;
}
