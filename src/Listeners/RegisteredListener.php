<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\RegisteredEventContract;
use Illuminate\Auth\Events\Registered;

class RegisteredListener
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected RegisteredEventContract $contract, protected array $attributes = [])
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
    public function handle(Registered $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
