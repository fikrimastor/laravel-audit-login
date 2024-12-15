<?php

use FikriMastor\AuditLogin\Tests\TestModels\User;
use Illuminate\Auth\Events\{Attempting, Login, Logout};
use \Illuminate\Support\Facades\{Event, Auth};

it('can test event type login successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    Event::assertDispatched(Login::class);
});

it('can test event type logout successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::login($user);

    Auth::logout();

    Event::assertDispatched(Logout::class);
});

it('can test event type attempting successfully dispatched', function () {
    Event::fake();

    $user = User::firstOrCreate(['email' => TEST_USER_EMAIL]);

    Auth::attempt(['password' => $user->password, 'email' => $user->email]);

    Event::assertDispatched(Attempting::class);
});

it('can test event type register successfully dispatched', function () {

});

it('can test event type forgot password successfully dispatched', function () {

});

it('can test event type reset password successfully dispatched', function () {

});

it('can test event type failed login successfully dispatched', function () {

});

it('can test event type authenticated successfully dispatched', function () {

});

it('can test event type current device logout successfully dispatched', function () {

});

it('can test event type other device logout successfully dispatched', function () {

});

it('can test event type lockout successfully dispatched', function () {

});

it('can test event type password reset link sent successfully dispatched', function () {

});

it('can test event type validated successfully dispatched', function () {

});

it('can test event type verified successfully dispatched', function () {

});