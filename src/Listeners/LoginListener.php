<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListener implements ShouldQueue
{
    protected array $attributes = [];

    /**
     * Create a new event handler instance.
     */
    public function __construct(protected LoginEventContract $contract)
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
    public function handle(Login $event): void
    {
        $this->contract->handle($event, $this->attributes);
    }
}
