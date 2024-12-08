<?php

namespace FikriMastor\AuditLogin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FikriMastor\AuditLogin\AuditLogin
 */
class AuditLogin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FikriMastor\AuditLogin\AuditLogin::class;
    }
}
