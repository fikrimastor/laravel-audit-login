<?php

// config for FikriMastor/AuditLogin
return [
    'drivers' => [
        'database' => [
            'table' => 'audit_logins',
            'connection' => 'mysql',
        ],
    ],
    'user' => [
        'morph_prefix' => 'login_auditable',
    ],
    'events' => [
        'registered' => [
            'enabled' => true,
            'class' => \Illuminate\Auth\Events\Registered::class,
        ],
        'login' => [
            'enabled' => true,
            'class' => \Illuminate\Auth\Events\Login::class,
        ],
        'failed_login' => [
            'enabled' => true,
            'class' => \Illuminate\Auth\Events\Failed::class,
        ],
        'logout' => [
            'enabled' => true,
            'class' => \Illuminate\Auth\Events\Logout::class,
        ],
        'password_reset' => [
            'enabled' => true,
            'class' => \Illuminate\Auth\Events\PasswordReset::class,
        ],
        'attempting' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\Attempting::class,
        ],
        'authenticated' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\Authenticated::class,
        ],
        'current_device_logout' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\CurrentDeviceLogout::class,
        ],
        'lockout' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\Lockout::class,
        ],
        'other_device_logout' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\OtherDeviceLogout::class,
        ],
        'password_reset_link_sent' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\PasswordResetLinkSent::class,
        ],
        'validated' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\Validated::class,
        ],
        'verified' => [
            'enabled' => false,
            'class' => \Illuminate\Auth\Events\Verified::class,
        ],
    ],
    'subscriber' => \FikriMastor\AuditLogin\Listeners\AuditLoginSubscriber::class,
];
