<?php

use FikriMastor\AuditLogin\AuditLoginAttribute;
use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Http\Request;

beforeEach(function () {
    migrateTable();
});

it('can test authenticatable class were have authLogs relationship', function () {
    expect(method_exists(user(), 'authLogs'))->toBeTrue();
});

it('can test authenticatable class does not have authLogs relationship', function () {
    $user = new \FikriMastor\AuditLogin\Tests\TestModels\UserWithoutAuditAuthenticatableTrait;

    expect(method_exists($user, 'authLogs'))->toBeFalse();
});

it('can test authenticatable class have authLogs many records', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->isNotEmpty())->toBeTrue();
});

it('can test authenticatable class have authLogs many records with url contains localhost', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->pluck('url')->contains(fn ($url) => str($url)->contains('localhost')))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with ip address contains 127.0.0.1', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->pluck('ip_address')->contains(fn ($ipAddress) => str($ipAddress)->contains('127.0.0.1')))->toBeTrue();
});

it('can test authenticatable class have authLogs many records with user agent is not empty', function () {
    $request = app(Request::class);
    $testLogs = [];

    for ($i = 0; $i < TEST_COUNT; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, EventTypeEnum::LOGIN))->toArray();
    }

    user()->authLogs()->createMany($testLogs);

    expect(user()->authLogs->pluck('user_agent')->isNotEmpty())->toBeTrue();
});
