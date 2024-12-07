<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredListener implements ShouldQueue
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected RegisteredEventContract $contract, protected array $attributes = [])
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
