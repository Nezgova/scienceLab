<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Article; // Ensure you import the Article model

class User extends Authenticatable
{
    protected $fillable = [
        'username', 'email', 'password', 'profile_picture', 
        'description', 'sex', 'specialties', 'interests'
    ];

    protected $casts = [
        'interests' => 'array',
        'specialties' => 'array',
    ];
    

    // Define the relationship between User and Article
    public function articles()
    {
        return $this->hasMany(Article::class); // A user can have many articles
    }
}
