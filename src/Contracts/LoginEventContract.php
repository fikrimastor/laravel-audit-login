<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Auth\Events\Login;

interface LoginEventContract
{
    public function handle(Login $event, array $attributes): void;
}
