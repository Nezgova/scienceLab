<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'username', 'email', 'password', 'profile_picture', 
        'description', 'sex', 'specialties', 'interests'
    ];

    protected $casts = [
        'specialties' => 'string',
        'interests' => 'string',
    ];
}
