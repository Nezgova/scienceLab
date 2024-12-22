<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'title', 'link', 'votes'];

    // Define relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function votes()
    {
        return $this->hasMany(UserVote::class);
    }

    // Add a helper to count votes if you use the UserVote relationship
    public function getVoteCountAttribute()
    {
        return $this->votes->count();  // Count votes using the UserVote relationship
    }
}

