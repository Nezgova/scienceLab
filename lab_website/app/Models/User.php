<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Article;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'group_id', 'profile_picture', 
        'description', 'sex', 'specialties', 'interests', 'is_admin'
    ];
    
    

    protected $casts = [
        'interests' => 'array',
        'specialties' => 'array',
        'is_admin' => 'boolean',  // Cast admin flag to boolean
    ];
    
    // Helper method to check if the user is an admin
    public function isAdmin()
    {
        return $this->is_admin === true;
    }

    // Define the relationship to articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id'); // Explicitly specify the foreign key
    }
    // User Model
public function group()
{
    return $this->belongsTo(Group::class);
}

}
