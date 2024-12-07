<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Auth\Events\Logout;

interface LogoutEventContract
{
    public function handle(Logout $event, array $attributes): void;
}