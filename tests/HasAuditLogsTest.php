<?php

use FikriMastor\AuditLogin\AuditLoginAttribute;

it('can test authenticatable class were have authLogs relationship', function () {
    $user = new \FikriMastor\AuditLogin\Tests\TestModels\User();

    expect(method_exists($user, 'authLogs'))->toBeTrue();
});

it('can test authenticatable class does not have authLogs relationship', function () {
    $user = new \FikriMastor\AuditLogin\Tests\TestModels\UserWithoutAuditAuthenticatableTrait();

    expect(method_exists($user, 'authLogs'))->toBeFalse();
});

it('can test authenticatable class have authLogs many records', function () {
    $user = \FikriMastor\AuditLogin\Tests\TestModels\User::firstOrCreate(['email' => 'admin@email.com']);

    $request = app(\Illuminate\Http\Request::class);
    $testCount = 10;
    $testLogs = [];

    for ($i = 0; $i < $testCount; $i++) {
        $testLogs[] = (new AuditLoginAttribute($request, \FikriMastor\AuditLogin\Enums\EventTypeEnum::LOGIN))->toArray();
    }

    $user->authLogs()->createMany($testLogs);

    expect($user->authLogs->isNotEmpty())->toBeTrue();
});