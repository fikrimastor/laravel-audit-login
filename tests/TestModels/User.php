<?php

namespace FikriMastor\AuditLogin\Tests\TestModels;

use FikriMastor\AuditLogin\Traits\AuditAuthenticatableTrait;

class User extends UserWithoutAuditAuthenticatableTrait
{
    use AuditAuthenticatableTrait;
}