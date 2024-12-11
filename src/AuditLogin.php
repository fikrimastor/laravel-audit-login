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
     *
     * @param  object  $event
     * @param  AuditLoginAttribute  $attributes
     * @return void
     */
    public function auditEvent(object $event, AuditLoginAttribute $attributes): void
    {
        if ($this->isAuditEnabled() === true) {
            try {
                throw_if(is_null($attributes->eventType), new BadRequestException('The event type must not be empty.'));

                $this->execute($event, $attributes);
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }

    /**
     * Audit a login event.
     *
     * @param  object  $event
     * @param  AuditLoginAttribute  $attributes
     * @return void
     */
    private function execute(object $event, AuditLoginAttribute $attributes): void
    {
        DB::transaction(function () use ($event, $attributes) {
            $user = $event->user ?? null;
            $attributes = $attributes->toArray();

            if (!$user instanceof Authenticatable) {
                return $this->executeNullUser($attributes);
            }

            // Create an audit entry with a custom event (e.g., login, logout)
            return $this->executeAuthenticatable($user, $attributes);
        });
    }

    /**
     * Execute audit an event for null user.
     *
     * @param  array  $attributes
     * @return AuditLoginModel
     */
    private function executeNullUser(array $attributes): AuditLoginModel
    {
        $morphPrefix = config('audit-login.user.morph-prefix', 'login_auditable');

        $dataMissing = [
            $morphPrefix . '_id' => null,
            $morphPrefix . '_type' => null,
        ];

        return AuditLoginModel::create(array_merge($attributes, $dataMissing));
    }

    /**
     * Execute audit an event for Authenticatable.
     *
     * @param  Authenticatable  $user
     * @param  array  $attributes
     * @return AuditLoginModel
     * @throws \Throwable
     */
    private function executeAuthenticatable(Authenticatable $user, array $attributes): AuditLoginModel
    {
        throw_if(! method_exists($user, 'authLogs'), new BadRequestException('The user model must use the AuditAuthenticatableTrait.'));

        return $user->authLogs()->create($attributes);
    }

    /**
     * Check audit is enabled.
     *
     * @return bool
     */
    public function isAuditEnabled(): bool
    {
        return config('audit-login.enabled', true);
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
     *
     * @param  string|\Closure  $callback
     * @return void
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
     * @param  string|\Closure  $callback
     * @return void
     */
    public static function recordValidatedUsing(string|\Closure $callback): void
    {
        app()->singleton(ValidatedEventContract::class, $callback);
    }

    /**
     * Register a class / callback that should be used to record Verified event.
     *
     * @param string|\Closure $callback
     * @return void
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

    /**
     * Get the event class for the specific event.
     *  If the event is not provided, it will return false.
     */
    public function getEventClass(?EventTypeEnum $event = null): string
    {
        return match ($event) {
            EventTypeEnum::ATTEMPTING => config('audit-login.events.attempting.class', Attempting::class),
            EventTypeEnum::LOGOUT => config('audit-login.events.logout.class', Logout::class),
            EventTypeEnum::FAILED_LOGIN => config('audit-login.events.failed-login.class', Failed::class),
            EventTypeEnum::REGISTER => config('audit-login.events.registered.class', Registered::class),
            EventTypeEnum::AUTHENTICATED => config('audit-login.events.authenticated.class', Authenticated::class),
            EventTypeEnum::CURRENT_DEVICE_LOGOUT => config('audit-login.events.current-device-logout.class', CurrentDeviceLogout::class),
            EventTypeEnum::LOCKOUT => config('audit-login.events.lockout.class', Lockout::class),
            EventTypeEnum::OTHER_DEVICE_LOGOUT => config('audit-login.events.other-device-logout.class', OtherDeviceLogout::class),
            EventTypeEnum::RESET_PASSWORD => config('audit-login.events.password-reset.class', PasswordReset::class),
            EventTypeEnum::PASSWORD_RESET_LINK_SENT => config('audit-login.events.password-reset-link-sent.class', PasswordResetLinkSent::class),
            EventTypeEnum::VALIDATED => config('audit-login.events.validated.class', Validated::class),
            EventTypeEnum::VERIFIED => config('audit-login.events.verified.class', Verified::class),
            EventTypeEnum::LOGIN => config('audit-login.events.login.class', Login::class),
            default => '',
        };
    }
}
