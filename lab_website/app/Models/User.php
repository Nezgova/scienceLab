<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'username',
        'password',
        'role',
        'profile_picture',
        'description',
        'sex',
        'specialties',
        'interests',
    ];

    // Cast specialties and interests as arrays
    protected $casts = [
        'specialties' => 'array',
        'interests' => 'array',
    ];

    // Define relationships
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function votes()
    {
        return $this->hasMany(UserVote::class);
    }
}
