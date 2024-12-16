<?php

namespace FikriMastor\AuditLogin\Tests\TestModels;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class UserWithoutAuditAuthenticatableTrait extends AuthenticatableContract implements MustVerifyEmail
{
    use Notifiable;
    use Authenticatable;

    protected $fillable = ['email'];

    public $timestamps = false;

    protected $table = 'users';
}
