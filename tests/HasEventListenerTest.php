<?php

use FikriMastor\AuditLogin\Listeners\AuditLoginSubscriber;
use FikriMastor\AuditLogin\Tests\TestModels\User;
use Illuminate\Auth\Events\{Attempting,
    Authenticated,
    CurrentDeviceLogout,
    Failed,
    Lockout,
    Login,
    Logout,
    OtherDeviceLogout,
    PasswordReset,
    PasswordResetLinkSent,
    Registered,
    Validated,
    Verified};
use \Illuminate\Support\Facades\{Event, Auth};
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Http\Request;

uses(RefreshDatabase::class);

it('can test event type login successfully dispatched', function () {
    Event::fake([Login::class]);

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    $this->actingAs($user, 'web');

    Event::assertDispatched(Login::class);

    Event::assertDispatched(fn (Login $event) =>  $event->user->id === $user->id);

    Event::assertListening(
        Login::class,
        [AuditLoginSubscriber::class, 'handleLoginEventLog']
    );
});

it('can test event type logout successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    Auth::logout();

    Event::assertListening(
        Logout::class,
        [AuditLoginSubscriber::class, 'handleLogoutEventLog']
    );

    Event::assertDispatched(Logout::class);

    Event::assertDispatched(fn (Logout $event) =>  $event->user->id === $user->id);
});

it('can test event type attempting successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::attempt(['password' => $user->password, 'email' => $user->email]);

    Event::assertListening(
        Attempting::class,
        [AuditLoginSubscriber::class, 'handleAttemptingEventLog']
    );

    Event::assertDispatched(Attempting::class);

    Event::assertDispatched(fn (Attempting $event) =>  $event->credentials['email'] === $user->email);
});

it('can test event type register successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Registered($user));

    Event::assertListening(
        Registered::class,
        [AuditLoginSubscriber::class, 'handleRegisteredEventLog']
    );

    Event::assertDispatched(Registered::class);

    Event::assertDispatched(fn (Registered $event) => $event->user?->id === $user->id);
});

it('can test event type forgot password successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new PasswordReset($user));

    Event::assertListening(
        PasswordReset::class,
        [AuditLoginSubscriber::class, 'handlePasswordResetEventLog']
    );

    Event::assertDispatched(PasswordReset::class);

    Event::assertDispatched(fn (PasswordReset $event) => $event->user?->id === $user->id);
});

it('can test event type failed login successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Failed('web', $user, ['email' => $user->email]));

    Event::assertListening(
        Failed::class,
        [AuditLoginSubscriber::class, 'handleFailedEventLog']
    );

    Event::assertDispatched(Failed::class);

    Event::assertDispatched(fn (Failed $event) => $event->user?->id === $user->id || $event->credentials['email'] === $user->email);
});

it('can test event type authenticated successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Authenticated('web', $user));

    Event::assertListening(
        Authenticated::class,
        [AuditLoginSubscriber::class, 'handleAuthenticatedEventLog']
    );

    Event::assertDispatched(Authenticated::class);

    Event::assertDispatched(fn (Authenticated $event) => $event->user?->id === $user->id);
});

it('can test event type current device logout successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new CurrentDeviceLogout('web', $user));

    Event::assertListening(
        CurrentDeviceLogout::class,
        [AuditLoginSubscriber::class, 'handleCurrentDeviceLogoutEventLog']
    );

    Event::assertDispatched(CurrentDeviceLogout::class);

    Event::assertDispatched(fn (CurrentDeviceLogout $event) => $event->user?->id === $user->id);
});

it('can test event type other device logout successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new OtherDeviceLogout('web', $user));

    Event::assertListening(
        OtherDeviceLogout::class,
        [AuditLoginSubscriber::class, 'handleOtherDeviceLogoutEventLog']
    );

    Event::assertDispatched(OtherDeviceLogout::class);

    Event::assertDispatched(fn (OtherDeviceLogout $event) => $event->user?->id === $user->id);
});

it('can test event type lockout successfully dispatched', function () {
    $request = resolve(Request::class);

    Event::fake();

    event(new Lockout($request));

    Event::assertListening(
        Lockout::class,
        [AuditLoginSubscriber::class, 'handleLockoutEventLog']
    );

    Event::assertDispatched(Lockout::class);

    Event::assertDispatched(fn (Lockout $event) => $event->request->ip() === $request->ip());
});

it('can test event type password reset link sent successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new PasswordResetLinkSent($user));

    Event::assertListening(
        PasswordResetLinkSent::class,
        [AuditLoginSubscriber::class, 'handlePasswordResetLinkSentEventLog']
    );

    Event::assertDispatched(PasswordResetLinkSent::class);

    Event::assertDispatched(fn (PasswordResetLinkSent $event) => $event->user?->id === $user->id);
});

it('can test event type validated successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Validated('web', $user));

    Event::assertListening(
        Validated::class,
        [AuditLoginSubscriber::class, 'handleValidatedEventLog']
    );

    Event::assertDispatched(Validated::class);

    Event::assertDispatched(fn (Validated $event) => $event->user?->id === $user->id);
});

it('can test event type verified successfully dispatched', function () {
    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Event::fake();

    event(new Verified($user));

    Event::assertListening(
        Verified::class,
        [AuditLoginSubscriber::class, 'handleVerifiedEventLog']
    );

    Event::assertDispatched(Verified::class);

    Event::assertDispatched(fn (Verified $event) => $event->user?->id === $user->id);
});