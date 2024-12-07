<?php

namespace FikriMastor\LaravelAuditLogin;

use FikriMastor\LaravelAuditLogin\Contracts\{LoginEventContract, FailedLoginEventContract, LogoutEventContract, PasswordResetEventContract, RegisteredEventContract};
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

    /**
     * Register a class / callback that should be used to record login event.
     *
     * @param  string  $callback
     * @return void
     */
    public static function recordLoginUsing(string $callback): void
    {
        app()->bind(LoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record logout event.
     *
     * @param  string  $callback
     * @return void
     */
    public static function recordLogoutUsing(string $callback): void
    {
        app()->bind(LogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record forgot password event.
     *
     * @param  string  $callback
     * @return void
     */
    public static function recordForgotPasswordUsing(string $callback): void
    {
        app()->bind(PasswordResetEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record failed login event.
     *
     * @param  string  $callback
     * @return void
     */
    public static function recordFailedLoginUsing(string $callback): void
    {
        app()->bind(FailedLoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record registered event.
     *
     * @param  string  $callback
     * @return void
     */
    public static function recordRegisteredUsing(string $callback): void
    {
        app()->bind(RegisteredEventContract::class, $callback);
    }
}
