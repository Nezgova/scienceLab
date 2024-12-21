<?php

namespace App\Http\Controllers;

use App\Models\UserVote;
use Illuminate\Http\Request;

class UserVoteController extends Controller
{
    public function index()
    {
        $votes = UserVote::all();
        return response()->json($votes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'article_id' => 'required|exists:articles,id',
            'vote' => 'required|integer',
        ]);

        $vote = UserVote::create($validated);
        return response()->json($vote);
    }

    public function show($id)
    {
        $vote = UserVote::findOrFail($id);
        return response()->json($vote);
    }

    public function update(Request $request, $id)
    {
        $vote = UserVote::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'exists:users,id',
            'article_id' => 'exists:articles,id',
            'vote' => 'integer',
        ]);

        $vote->update($validated);
        return response()->json($vote);
    }

    public function destroy($id)
    {
        $vote = UserVote::findOrFail($id);
        $vote->delete();
        return response()->json(['message' => 'Vote deleted successfully']);
    }
}
