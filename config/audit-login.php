<?php

// config for FikriMastor/LaravelAuditLogin
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
];
