<?php

namespace FikriMastor\AuditLogin\Models;

use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

class AuditLogin extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'metadata' => 'json',
        'event' => EventTypeEnum::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function auditable(): MorphTo
    {
        $morphPrefix = config('audit-login.user.morph-prefix', 'login_auditable');

        return $this->morphTo(__FUNCTION__, $morphPrefix.'_type', $morphPrefix.'_id');
    }

    /**
     * Scope a query to only include the last login event.
     *
     * @param Builder $query
     */
    public function scopeLastLoginAt(Builder $query): void
    {
        $query->where('event', EventTypeEnum::FAILED_LOGIN)->latest('id');
    }

    /**
     * Scope a query to only include the last successful login event.
     *
     * @param Builder $query
     */
    public function scopeLastSuccessfulLoginAt(Builder $query): void
    {
        $query->where('event', EventTypeEnum::LOGIN)->latest('id');
    }

    /**
     * Scope a query to only include the last login ip address.
     *
     * @param Builder $query
     */
    public function scopeLastLoginIpAddress(Builder $query): void
    {
        $query->where('event', EventTypeEnum::FAILED_LOGIN)->latest('id');
    }

    /**
     * Scope a query to only include the last successful login ip address.
     *
     * @param Builder $query
     */
    public function scopeLastSuccessfulLoginIpAddress(Builder $query): void
    {
        $query->where('event', EventTypeEnum::LOGIN)->latest('id');
    }
}
