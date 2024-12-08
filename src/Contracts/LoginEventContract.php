<?php

namespace FikriMastor\AuditLogin\Contracts;

use Illuminate\Auth\Events\Login;

interface LoginEventContract
{
    public function handle(Login $event, array $attributes): void;
}
