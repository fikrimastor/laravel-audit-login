<?php

namespace FikriMastor\AuditLogin\Enums;

enum EventTypeEnum: string
{
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case REGISTER = 'register';
    case RESET_PASSWORD = 'reset_password';
    case FAILED_LOGIN = 'failed_login';
    case ATTEMPTING = 'attempting';
    case AUTHENTICATED = 'authenticated';
    case CURRENT_DEVICE_LOGOUT = 'current_device_logout';
    case LOCKOUT = 'lockout';
    case OTHER_DEVICE_LOGOUT = 'other_device_logout';
    case PASSWORD_RESET_LINK_SENT = 'password_reset_link_sent';
    case VALIDATED = 'validated';
    case VERIFIED = 'verified';
}
