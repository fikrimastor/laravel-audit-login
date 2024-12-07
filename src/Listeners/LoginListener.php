<?php

namespace FikriMastor\LaravelAuditLogin\Listeners;

use FikriMastor\LaravelAuditLogin\Contracts\LoginEventContract;
use Illuminate\Auth\Events\Login;

class LoginListener
{
    /**
     * Create a new event handler instance.
     */
    public function __construct(protected LoginEventContract $contract, protected array $attributes = [])
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
