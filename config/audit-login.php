<?php

// config for FikriMastor/AuditLogin
return [
    'enabled' => env('AUDIT_LOGIN_ENABLED', true),
    'drivers' => [
        'database' => [
            'table' => env('AUDIT_LOGIN_DATABASE_TABLE', 'audit-logins'),
            'connection' => env('AUDIT_LOGIN_DATABASE_CONNECTION', 'mysql'),
        ],
    ],
    'user' => [
        'morph-prefix' => env('AUDIT_LOGIN_USER_PREFIX', 'login_auditable'),
    ],
    'events' => [
        'registered' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_REGISTERED', true),
            'class' =>  \Illuminate\Auth\Events\Registered::class,
        ],
        'login' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOGIN', true),
            'class' =>  \Illuminate\Auth\Events\Login::class,
        ],
        'failed-login' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_FAILED_LOGIN', true),
            'class' =>  \Illuminate\Auth\Events\Failed::class,
        ],
        'logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOGOUT', true),
            'class' =>  \Illuminate\Auth\Events\Logout::class,
        ],
        'password-reset' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_PASSWORD_RESET', false),
            'class' =>  \Illuminate\Auth\Events\PasswordReset::class,
        ],
        'attempting' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_ATTEMPTING', false),
            'class' =>  \Illuminate\Auth\Events\Attempting::class,
        ],
        'authenticated' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_AUTHENTICATED', false),
            'class' =>  \Illuminate\Auth\Events\Authenticated::class,
        ],
        'current-device-logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_CURRENT_DEVICE_LOGOUT', false),
            'class' =>  \Illuminate\Auth\Events\CurrentDeviceLogout::class,
        ],
        'lockout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_LOCKOUT', false),
            'class' =>  \Illuminate\Auth\Events\Lockout::class,
        ],
        'other-device-logout' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_OTHER_DEVICE_LOGOUT', false),
            'class' =>  \Illuminate\Auth\Events\OtherDeviceLogout::class,
        ],
        'password-reset-link-sent' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_PASSWORD_RESET_LINK_SENT', false),
            'class' =>  \Illuminate\Auth\Events\PasswordResetLinkSent::class,
        ],
        'validated' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_VALIDATED', false),
            'class' =>  \Illuminate\Auth\Events\Validated::class,
        ],
        'verified' => [
            'enabled' => env('AUDIT_LOGIN_EVENT_VERIFIED', false),
            'class' =>  \Illuminate\Auth\Events\Verified::class,
        ],
    ],
    'subscriber' => \FikriMastor\AuditLogin\Listeners\AuditLoginSubscriber::class,
];
