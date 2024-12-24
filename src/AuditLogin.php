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
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use FikriMastor\AuditLogin\Exceptions\BadRequestException;
use FikriMastor\AuditLogin\Models\AuditLogin as AuditLoginModel;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Validated;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class AuditLogin
{
    /**
     * Audit an event.
     */
    public static function auditEvent(object $event, AuditLoginAttribute $attributes): ?AuditLoginModel
    {
        $auditLog = null;
        if (self::isAuditEnabled() === true) {
            try {
                throw_if(is_null($attributes->eventType), new BadRequestException('The event type must not be empty.'));

                $auditLog = self::execute($event, $attributes);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $auditLog;
    }

    /**
     * Audit a login event.
     */
    private static function execute(object $event, AuditLoginAttribute $attributes): AuditLoginModel
    {
        return DB::transaction(function () use ($event, $attributes) {
            $user = $event->user ?? null;
            $attributes = $attributes->toArray();

            if (! $user instanceof Authenticatable) {
                return self::executeNullUser($attributes);
            }

            // Create an audit entry with a custom event (e.g., login, logout)
            return self::executeAuthenticatable($user, $attributes);
        });
    }

    /**
     * Execute audit an event for null user.
     */
    private static function executeNullUser(array $attributes): AuditLoginModel
    {
        $morphPrefix = config('audit-login.user.morph-prefix', 'login_auditable');

        $dataMissing = [
            $morphPrefix.'_id' => null,
            $morphPrefix.'_type' => null,
        ];

        return AuditLoginModel::create(array_merge($attributes, $dataMissing));
    }

    /**
     * Execute audit an event for Authenticatable.
     *
     * @throws \Throwable
     */
    private static function executeAuthenticatable(Authenticatable $user, array $attributes): AuditLoginModel
    {
        throw_if(! method_exists($user, 'authLogs'), new BadRequestException('The user model must use the AuditAuthenticatableTrait.'));

        return $user->authLogs()->create($attributes);
    }

    /**
     * Check audit is enabled.
     */
    public static function isAuditEnabled(): bool
    {
        return config('audit-login.enabled', true);
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
        if (app()->version() >= 11) {
            app()->singleton(PasswordResetLinkSentEventContract::class, $callback);
        }
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

    /**
     * Determine if the verified event should be logged.
     * If the event is not provided, it will return false.
     */
    public function allowedLog(?EventTypeEnum $event = null): bool
    {
        return match ($event) {
            EventTypeEnum::ATTEMPTING => config('audit-login.events.attempting.enabled', false),
            EventTypeEnum::LOGOUT => config('audit-login.events.logout.enabled', true),
            EventTypeEnum::FAILED_LOGIN => config('audit-login.events.failed-login.enabled', true),
            EventTypeEnum::REGISTER => config('audit-login.events.registered.enabled', false),
            EventTypeEnum::AUTHENTICATED => config('audit-login.events.authenticated.enabled', false),
            EventTypeEnum::CURRENT_DEVICE_LOGOUT => config('audit-login.events.current-device-logout.enabled', false),
            EventTypeEnum::LOCKOUT => config('audit-login.events.lockout.enabled', false),
            EventTypeEnum::OTHER_DEVICE_LOGOUT => config('audit-login.events.other-device-logout.enabled', false),
            EventTypeEnum::RESET_PASSWORD => config('audit-login.events.password-reset.enabled', false),
            EventTypeEnum::PASSWORD_RESET_LINK_SENT => config('audit-login.events.password-reset-link-sent.enabled', false),
            EventTypeEnum::VALIDATED => config('audit-login.events.validated.enabled', false),
            EventTypeEnum::VERIFIED => config('audit-login.events.verified.enabled', false),
            EventTypeEnum::LOGIN => config('audit-login.events.login.enabled', true),
            default => false,
        };
    }
}
