<?php

namespace FikriMastor\AuditLogin\Traits;

use FikriMastor\AuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait AuditAuthenticatableTrait
{
    public function auditLogin(): MorphMany
    {
        return $this->morphMany(AuditLoginModel::class, config('audit-login.user.morph-prefix', 'login_auditable'));
    }
}
