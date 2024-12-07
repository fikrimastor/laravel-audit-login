<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use Illuminate\Auth\Events\Failed;

class FailedListener
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected FailedLoginEventContract $contract, protected array $attributes = [])
    {
        $this->attributes = [
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
