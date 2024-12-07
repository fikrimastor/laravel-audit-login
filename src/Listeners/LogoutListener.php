<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\LogoutEventContract;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogoutListener implements ShouldQueue
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected LogoutEventContract $contract, protected array $attributes = [])
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
