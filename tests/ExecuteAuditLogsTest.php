<?php

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use FikriMastor\AuditLogin\Facades\AuditLogin;
use FikriMastor\AuditLogin\Tests\TestModels\User;
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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('can test event type login successfully dispatched', function () {
    Event::fake([Login::class]);

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    $this->actingAs($user, 'web');

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::LOGIN);

    Event::assertDispatched(fn (Login $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type logout successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    Auth::logout();

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::LOGOUT);

    Event::assertDispatched(fn (Logout $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type attempting successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::attempt(['password' => $user->password, 'email' => $user->email]);

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::ATTEMPTING);

    Event::assertDispatched(fn (Attempting $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type register successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Registered($user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::REGISTER);

    Event::assertDispatched(fn (Registered $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type forgot password successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new PasswordReset($user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::RESET_PASSWORD);

    Event::assertDispatched(fn (PasswordReset $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type failed login successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Failed('web', $user, ['email' => $user->email]));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::FAILED_LOGIN);

    Event::assertDispatched(fn (Failed $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type authenticated successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Authenticated('web', $user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::AUTHENTICATED);

    Event::assertDispatched(fn (Authenticated $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type current device logout successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new CurrentDeviceLogout('web', $user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::CURRENT_DEVICE_LOGOUT);

    Event::assertDispatched(fn (CurrentDeviceLogout $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type other device logout successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new OtherDeviceLogout('web', $user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::OTHER_DEVICE_LOGOUT);

    Event::assertDispatched(fn (OtherDeviceLogout $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type lockout successfully dispatched', function () {
    $request = resolve(Request::class);

    Event::fake();

    event(new Lockout($request));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::LOCKOUT);

    Event::assertDispatched(fn (Lockout $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type password reset link sent successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    if((float) app()->version() > 11) {
        Event::fake();

        event(new PasswordResetLinkSent($user));

        $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::PASSWORD_RESET_LINK_SENT);

        Event::assertDispatched(fn (PasswordResetLinkSent $event) => AuditLogin::auditEvent($event, $attributes));

        $this->assertDatabaseCount('audit_logins', 1);
    }

    $this->assertDatabaseCount('users', 1);
});

it('can test event type validated successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Validated('web', $user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::VALIDATED);

    Event::assertDispatched(fn (Validated $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});

it('can test event type verified successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    Auth::login($user);

    event(new Verified($user));

    $attributes = new AuditLoginAttribute(resolve(Request::class), EventTypeEnum::VERIFIED);

    Event::assertDispatched(fn (Verified $event) => AuditLogin::auditEvent($event, $attributes));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('audit_logins', 1);
});
