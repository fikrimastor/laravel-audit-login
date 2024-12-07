<?php

namespace FikriMastor\LaravelAuditLogin\Enums;

enum EventTypeEnum: string
{
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case REGISTER = 'register';
    case FORGOT_PASSWORD = 'forgot_password';
    case RESET_PASSWORD = 'reset_password';
    case FAILED_LOGIN = 'failed_login';
}
