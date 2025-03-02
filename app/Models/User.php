<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role', 'username', 'email', 'password', 'phone', 'address', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false; // Tắt timestamps vì migration không có updated_at
}
