<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Exceptions\BadRequestException;
use FikriMastor\LaravelAuditLogin\Models\AuditLogin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class LaravelAuditLogin
{
    /**
     * Audit an event.
     *
     * @throws \Throwable
     */
    public static function auditEvent(array $attributes, ?Authenticatable $user = null): Model
    {
        throw_if(! method_exists($user, 'auditLogin'), new BadRequestException('The user model must use the AuditableTrait trait.'));

        throw_if(! isset($attributes['event']), new BadRequestException('The event_type must not be empty.'));

        if (! $user instanceof Authenticatable) {
            $morphPrefix = config('audit-login.user.morph_prefix', 'user');

            $dataMissing = [
                $morphPrefix.'_id' => null,
                $morphPrefix.'_type' => $morphPrefix,
            ];

            return AuditLogin::create(array_merge($attributes, $dataMissing));
        }

        // Create an audit entry with a custom event (e.g., login, logout)
        return $user->auditLogin()->create($attributes);
    }
}
