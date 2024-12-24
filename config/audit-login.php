<?php

// config for FikriMastor/AuditLogin
return [
    'enabled' => env('AUDIT_LOGIN_ENABLED', true),
    'drivers' => [
        'database' => [
            'table' => env('AUDIT_LOGIN_DATABASE_TABLE', 'audit-logins'),
            'connection' => env('AUDIT_LOGIN_DATABASE_CONNECTION', config('database.default', 'mysql')),
        ],
    ],
    'user' => [
        'morph-prefix' => env('AUDIT_LOGIN_USER_PREFIX', 'login_auditable'),
    ],
    'events' => [
        'registered' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_REGISTERED', true),
        ],
        'login' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOGIN', true),
        ],
        'failed-login' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_FAILED_LOGIN', true),
        ],
        'logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOGOUT', true),
        ],
        'password-reset' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_PASSWORD_RESET', false),
        ],
        'attempting' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_ATTEMPTING', false),
        ],
        'authenticated' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_AUTHENTICATED', false),
        ],
        'current-device-logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_CURRENT_DEVICE_LOGOUT', false),
        ],
        'lockout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOCKOUT', false),
        ],
        'other-device-logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_OTHER_DEVICE_LOGOUT', false),
        ],
        'password-reset-link-sent' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_PASSWORD_RESET_LINK_SENT', false),
        ],
        'validated' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_VALIDATED', false),
        ],
        'verified' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_VERIFIED', false),
        ],
    ],
    'subscriber' => \FikriMastor\AuditLogin\Listeners\AuditLoginSubscriber::class,
];
