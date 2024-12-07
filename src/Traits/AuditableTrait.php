<?php

namespace FikriMastor\LaravelAuditLogin\Traits;

use FikriMastor\LaravelAuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait AuditableTrait
{
    public function auditLogin(): MorphMany
    {
        return $this->morphMany(AuditLoginModel::class, config('audit-login.user.morph_prefix', 'login_auditable'));
    }
}