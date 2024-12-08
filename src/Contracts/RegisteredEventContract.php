<?php

namespace FikriMastor\AuditLogin\Contracts;

use Illuminate\Auth\Events\Registered;

interface RegisteredEventContract
{
    public function handle(Registered $event, array $attributes): void;
}
