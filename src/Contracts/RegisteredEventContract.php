<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Auth\Events\Registered;

interface RegisteredEventContract
{
    public function handle(Registered $event, array $attributes): void;
}