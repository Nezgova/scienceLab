<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVoteController extends Controller
{
    public function upvote($id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);

        $existingVote = $article->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            $existingVote->delete();
        } else {
            $article->votes()->create(['user_id' => $user->id, 'vote' => 1]);
        }

        return response()->json(['totalVotes' => $article->votes()->sum('vote')]);
    }

    public function downvote($id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);

        $existingVote = $article->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            $existingVote->delete();
        } else {
            $article->votes()->create(['user_id' => $user->id, 'vote' => -1]);
        }

        return response()->json(['totalVotes' => $article->votes()->sum('vote')]);
    }
}

