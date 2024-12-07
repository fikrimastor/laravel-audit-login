<?php

namespace FikriMastor\LaravelAuditLogin\Actions;

use FikriMastor\LaravelAuditLogin\Enums\EventTypeEnum;
use FikriMastor\LaravelAuditLogin\LaravelAuditLogin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

abstract class BaseEvent
{
    protected ?EventTypeEnum $eventType;

    protected array $attributes = [];

    protected ?Authenticatable $user = null;

    protected function execute(): void
    {
        $this->attributes['event'] = $this->eventType;
        DB::transaction(fn () => LaravelAuditLogin::auditEvent($this->attributes, $this->user));
    }
}
