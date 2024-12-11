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
    public static function auditEvent(object $event, AuditLoginAttribute $attributes): void
    {
        if (config('audit-login.enabled', true) === true) {
            try {
                throw_if(is_null($attributes->eventType), new BadRequestException('The event type must not be empty.'));

                DB::transaction(static function () use ($event, $attributes) {
                    $user = $event->user ?? null;
                    $attributes = $attributes->toArray();

                    if (! $user instanceof Authenticatable) {
                        $morphPrefix = config('audit-login.user.morph-prefix', 'login_auditable');

                        $dataMissing = [
                            $morphPrefix.'_id' => null,
                            $morphPrefix.'_type' => null,
                        ];

                        return AuditLoginModel::create(array_merge($attributes, $dataMissing));
                    }

                    throw_if(! method_exists($user, 'loginLogs'), new BadRequestException('The user model must use the AuditAuthenticatableTrait.'));

                    // Create an audit entry with a custom event (e.g., login, logout)
                    return $user->loginLogs()->create($attributes);
                });
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }

    /**
     * Register a class / callback that should be used to record login event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordLoginUsing(string|\Closure $callback): void
    {
        app()->singleton(LoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record logout event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(LogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record forgot password event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordForgotPasswordUsing(string|\Closure $callback): void
    {
        app()->singleton(PasswordResetEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record failed login event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordFailedLoginUsing(string|\Closure $callback): void
    {
        app()->singleton(FailedLoginEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record registered event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordRegisteredUsing(string|\Closure $callback): void
    {
        app()->singleton(RegisteredEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Attempting event.
     *
     * @param  string|\Closure  $callback
     * @return void
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
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordCurrentDeviceLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(CurrentDeviceLogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Lockout event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordLockoutUsing(string|\Closure $callback): void
    {
        app()->singleton(LockoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Other Device Logout event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordOtherDeviceLogoutUsing(string|\Closure $callback): void
    {
        app()->singleton(OtherDeviceLogoutEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Password Reset Link event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordPasswordResetLinkSentUsing(string|\Closure $callback): void
    {
        app()->singleton(PasswordResetLinkSentEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Validated event.
     *
     * @param string|\Closure $callback
     * @return void
     */
    public static function recordValidatedUsing(string|\Closure $callback): void
    {
        app()->singleton(ValidatedEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Verified event.
     *
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordVerifiedUsing(string|\Closure $callback): void
    {
        app()->singleton(VerifiedEventContract::class, $callback);
    }

    /**
     * Determine if the attempting event should be logged.
     *
     * @return bool
     */
    public static function allowAttemptingLog(): bool
    {
        return config('audit-login.events.attempting.enabled', false);
    }

    /**
     * Determine if the login event should be logged.
     *
     * @return bool
     */
    public static function allowLoginLog(): bool
    {
        return config('audit-login.events.login.enabled', true);
    }

    /**
     * Determine if the logout event should be logged.
     *
     * @return bool
     */
    public static function allowLogoutLog(): bool
    {
        return config('audit-login.events.logout.enabled', true);
    }

    /**
     * Determine if the failed login event should be logged.
     *
     * @return bool
     */
    public static function allowFailedLog(): bool
    {
        return config('audit-login.events.failed-login.enabled', true);
    }

    /**
     * Determine if the password reset event should be logged.
     *
     * @return bool
     */
    public static function allowPasswordResetLog(): bool
    {
        return config('audit-login.events.password-reset.enabled', false);
    }

    /**
     * Determine if the registered event should be logged.
     *
     * @return bool
     */
    public static function allowRegisteredLog(): bool
    {
        return config('audit-login.events.registered.enabled', false);
    }

    /**
     * Determine if the authenticated event should be logged.
     *
     * @return bool
     */
    public static function allowAuthenticatedLog(): bool
    {
        return config('audit-login.events.authenticated.enabled', false);
    }

    /**
     * Determine if the current device logout event should be logged.
     *
     * @return bool
     */
    public static function allowCurrentDeviceLogoutLog(): bool
    {
        return config('audit-login.events.current-device-logout.enabled', false);
    }

    /**
     * Determine if the other device logout event should be logged.
     *
     * @return bool
     */
    public static function allowOtherDeviceLogoutLog(): bool
    {
        return config('audit-login.events.other-device-logout.enabled', false);
    }

    /**
     * Determine if the lockout event should be logged.
     *
     * @return bool
     */
    public static function allowLockoutLog(): bool
    {
        return config('audit-login.events.lockout.enabled', false);
    }

    /**
     * Determine if the password reset link sent event should be logged.
     *
     * @return bool
     */
    public static function allowPasswordResetLinkSentLog(): bool
    {
        return config('audit-login.events.password-reset-link-sent.enabled', false);
    }

    /**
     * Determine if the validated event should be logged.
     *
     * @return bool
     */
    public static function allowValidatedLog(): bool
    {
        return config('audit-login.events.validated.enabled', false);
    }

    /**
     * Determine if the verified event should be logged.
     *
     * @return bool
     */
    public static function allowVerifiedLog(): bool
    {
        return config('audit-login.events.verified.enabled', false);
    }
}
