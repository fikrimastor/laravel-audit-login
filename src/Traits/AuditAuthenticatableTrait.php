<?php

namespace FikriMastor\AuditLogin\Traits;

use FikriMastor\AuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait AuditAuthenticatableTrait
{
    /**
     * Get the audit login relationship.
     */
    public function loginLogs(): MorphMany
    {
        return $this->morphMany(AuditLoginModel::class, config('audit-login.user.morph-prefix', 'login_auditable'))->latest('id');
    }

    /**
     * Get the last login at attribute.
     */
    public function lastLoginAt(): Attribute
    {
        return Attribute::get(get: fn () => $this->auditLogin()->lastLoginAt()->first()?->created_at);
    }

    /**
     * Get the last login at attribute.
     */
    public function lastSuccessfulLoginAt(): Attribute
    {
        return Attribute::get(get: fn () => $this->auditLogin()->lastSuccessfulLoginAt()->first()?->created_at);
    }

    /**
     * Get the last login ip address attribute.
     */
    public function lastLoginIpAddress(): Attribute
    {
        return Attribute::get(get: fn () => $this->auditLogin()->lastLoginIpAddress()->first()?->created_at);
    }

    /**
     * Get the last login ip address attribute.
     */
    public function lastSuccessfulLoginIpAddress(): Attribute
    {
        return Attribute::get(get: fn () => $this->auditLogin()->lastSuccessfulLoginIpAddress()->first()?->created_at);
    }
}
