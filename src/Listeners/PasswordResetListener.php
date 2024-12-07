<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetListener
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected PasswordResetEventContract $contract, protected array $attributes = [])
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
    public function handle(PasswordReset $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
