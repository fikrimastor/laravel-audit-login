<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\PasswordResetEventContract;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetListener implements ShouldQueue
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected PasswordResetEventContract $contract, protected array $attributes = [])
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
