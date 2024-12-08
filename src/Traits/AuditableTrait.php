<?php

namespace FikriMastor\AuditLogin\Traits;

use FikriMastor\AuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait AuditableTrait
{
    public function auditLogin(): MorphMany
    {
        return $this->morphMany(AuditLoginModel::class, config('audit-login.user.morph_prefix', 'login_auditable'));
    }
}
