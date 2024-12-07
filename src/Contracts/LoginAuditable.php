<?php

namespace FikriMastor\LaravelAuditLogin\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface LoginAuditable
{
    public function auditLogin(): MorphMany;
}
