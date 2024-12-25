<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'title', 'link'];

    // Define relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function votes()
    {
        return $this->hasMany(UserVote::class);
    }

    // Get upvotes for this article
    public function upvotes()
    {
        return $this->hasMany(UserVote::class)->where('vote', 1);
    }

    // Get downvotes for this article
    public function downvotes()
    {
        return $this->hasMany(UserVote::class)->where('vote', -1);
    }

    // Get net votes (upvotes - downvotes)
    public function netVotes()
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    // Check if a user has voted on this article and what vote they cast
    public function userVote($user_id)
    {
        return $this->votes()->where('user_id', $user_id)->first();
    }
}
