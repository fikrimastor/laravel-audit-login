<?php

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

uses(RefreshDatabase::class);

beforeEach(function () {
    migrateTable();
});

it('can test authenticatable class have authLogs many records with event type login', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::LOGIN))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type logout', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGOUT))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::LOGOUT))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type attempting', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::ATTEMPTING))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::ATTEMPTING))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type register', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::REGISTER))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::REGISTER))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type reset password', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::RESET_PASSWORD))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::RESET_PASSWORD))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type failed login', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::FAILED_LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::FAILED_LOGIN))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type authenticated', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::AUTHENTICATED))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::AUTHENTICATED))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type current device logout', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::CURRENT_DEVICE_LOGOUT))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::CURRENT_DEVICE_LOGOUT))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type other device logout', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::OTHER_DEVICE_LOGOUT))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::OTHER_DEVICE_LOGOUT))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type lockout', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOCKOUT))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::LOCKOUT))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type password reset link sent', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::PASSWORD_RESET_LINK_SENT))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::PASSWORD_RESET_LINK_SENT))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type validated', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::VALIDATED))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::VALIDATED))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with event type verified', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::VERIFIED))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->contains('event', EventTypeEnum::VERIFIED))->toBeTrue();
});
