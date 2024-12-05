<?php

namespace FikriMastor\LaravelAuditLogin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FikriMastor\LaravelAuditLogin\LaravelAuditLogin
 */
class LaravelAuditLogin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FikriMastor\LaravelAuditLogin\LaravelAuditLogin::class;
    }
}
