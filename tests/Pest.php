<?php

use FikriMastor\AuditLogin\Tests\TestCase;
use FikriMastor\AuditLogin\Tests\TestModels\User;

const TEST_COUNT = 10;

uses(TestCase::class)->in(__DIR__);

function migrateTable(): void
{
    if (! Schema::hasTable('audit_logins')) {
        Artisan::call('migrate', [
            '--path' => '../../../../tests/database/migrations/',
        ]);
    }
}

function user($email = 'pest@audit.com'): User
{
    return User::firstOrCreate(compact('email'));
}
