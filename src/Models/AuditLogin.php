<?php

namespace FikriMastor\LaravelAuditLogin\Models;

use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'old_values' => 'json',
        'new_values' => 'json',
        'event' => EventTypeEnum::class,
        // Note: Please do not add 'auditable_id' in here, as it will break non-integer PK models
    ];

    /**
     * {@inheritdoc}
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
