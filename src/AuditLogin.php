<?php

namespace FikriMastor\AuditLogin;

use FikriMastor\AuditLogin\Contracts\AttemptingEventContract;
use FikriMastor\AuditLogin\Contracts\AuthenticatedEventContract;
use FikriMastor\AuditLogin\Contracts\CurrentDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Contracts\FailedLoginEventContract;
use FikriMastor\AuditLogin\Contracts\LockoutEventContract;
use FikriMastor\AuditLogin\Contracts\LoginEventContract;
use FikriMastor\AuditLogin\Contracts\LogoutEventContract;
use FikriMastor\AuditLogin\Contracts\OtherDeviceLogoutEventContract;
use FikriMastor\AuditLogin\Contracts\PasswordResetEventContract;
use FikriMastor\AuditLogin\Contracts\PasswordResetLinkSentEventContract;
use FikriMastor\AuditLogin\Contracts\RegisteredEventContract;
use FikriMastor\AuditLogin\Contracts\ValidatedEventContract;
use FikriMastor\AuditLogin\Contracts\VerifiedEventContract;
use FikriMastor\AuditLogin\Exceptions\BadRequestException;
use FikriMastor\AuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class AuditLogin
{
    /**
     * Audit an event.
     */
    public static function auditEvent(array $attributes, object $event): void
    {
        try {
            DB::transaction(static function () use ($attributes, $event) {
                $user = $event->user ?? null;
                throw_if(! isset($attributes['event']), new BadRequestException('The event_type must not be empty.'));

                if (! $user instanceof Authenticatable) {
                    $morphPrefix = config('audit-login.user.morph_prefix', 'user');

                    $dataMissing = [
                        $morphPrefix.'_id' => null,
                        $morphPrefix.'_type' => $morphPrefix,
                    ];

                    return AuditLoginModel::create(array_merge($attributes, $dataMissing));
                }

                throw_if(! method_exists($user, 'auditLogin'), new BadRequestException('The user model must use the AuditAuthenticatableTrait.'));

                // Create an audit entry with a custom event (e.g., login, logout)
                return $user->auditLogin()->create($attributes);
            });
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Register a class / callback that should be used to record login event.
     */
    public static function recordLoginUsing(string|\Closure $callback): void
    {
        app()->singleton(LoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record logout event.
     */
    public static function recordLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(LogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record forgot password event.
     */
    public static function recordForgotPasswordUsing(string|\Closure $callback): void
    {
        app()->singleton(PasswordResetEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record failed login event.
     */
    public static function recordFailedLoginUsing(string|\Closure $callback): void
    {
        app()->singleton(FailedLoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record registered event.
     */
    public static function recordRegisteredUsing(string|\Closure $callback): void
    {
        app()->singleton(RegisteredEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Attempting event.
     */
    public static function recordAttemptingUsing(string|\Closure $callback): void
    {
        app()->singleton(AttemptingEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Authenticated event.
     */
    public static function recordAuthenticatedUsing(string|\Closure $callback): void
    {
        app()->singleton(AuthenticatedEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Current Device Logout event.
     */
    public static function recordCurrentDeviceLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(CurrentDeviceLogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Lockout event.
     */
    public static function recordLockoutUsing(string|\Closure $callback): void
    {
        app()->singleton(LockoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Other Device Logout event.
     */
    public static function recordOtherDeviceLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(OtherDeviceLogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Password Reset Link event.
     */
    public static function recordPasswordResetLinkSentUsing(string|\Closure $callback): void
    {
        app()->singleton(PasswordResetLinkSentEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Validated event.
     */
    public static function recordValidatedUsing(string|\Closure $callback): void
    {
        app()->singleton(ValidatedEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Verified event.
     */
    public static function recordVerifiedUsing(string|\Closure $callback): void
    {
        app()->singleton(VerifiedEventContract::class, $callback);
    }
}
