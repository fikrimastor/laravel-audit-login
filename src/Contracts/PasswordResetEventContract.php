<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Auth\Events\PasswordReset;

interface PasswordResetEventContract
{
    public function handle(PasswordReset $event, array $attributes): void;
}
