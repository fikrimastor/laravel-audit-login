<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Auth\Events\Failed;

interface FailedLoginEventContract
{
    public function handle(Failed $event, array $attributes): void;
}
