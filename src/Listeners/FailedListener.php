<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\FailedLoginEventContract;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;

class FailedListener implements ShouldQueue
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected FailedLoginEventContract $contract, protected array $attributes = [])
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
