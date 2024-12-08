<?php

namespace FikriMastor\AuditLogin\Contracts;

use Illuminate\Auth\Events\Logout;

interface LogoutEventContract
{
    public function handle(Logout $event, array $attributes): void;
}
