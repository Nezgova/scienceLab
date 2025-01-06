<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Specialty;

class ArticleController extends Controller
{
    // Display articles, specialties, and the form to submit a new one
    public function about(Request $request)
    {
        $search = $request->input('search');
    
        $articles = Article::with(['author', 'userVotes']) // Use 'userVotes' instead of 'votes'
            ->when($search, fn($query) => $query->where('title', 'like', "%$search%"))
            ->orderByDesc('created_at')
            ->paginate(10);
    
        $specialties = Specialty::all();
        $user = Auth::user();
    
        return view('about', compact('articles', 'specialties', 'user'));
    }
    

    // Store a new article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        // Create a new article with the authenticated user as the author
        Article::create([
            'title' => $request->title,
            'link' => $request->link,
            'author_id' => Auth::id(),
        ]);

        return Redirect::back()->with('message', 'Article submitted successfully!');
    }

    // Update an article
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        $article->update($validatedData);

        return redirect()->back()->with('success', 'Article updated successfully!');
    }

    // Delete an article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->author_id === Auth::id()) {
            $article->delete();
            return redirect()->back()->with('success', 'Article deleted successfully!');
        }

        return redirect()->back()->with('error', 'You are not authorized to delete this article!');
    }

    // Handle the voting logic (upvote or downvote)
    public function upvote($id)
{
    $user = Auth::user();
    $article = Article::findOrFail($id);

    $existingVote = $article->userVotes()->where('user_id', $user->id)->first();

    if ($existingVote) {
        if ($existingVote->vote === 1) {
            $existingVote->delete();
        } else {
            $existingVote->update(['vote' => 1]);
        }
    } else {
        UserVote::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'vote' => 1,
        ]);
    }

    $article->load('userVotes');

    return response()->json([
        'totalVotes' => $article->userVotes->sum('vote'),
        'userVote' => 1,
    ]);
}

public function downvote($id)
{
    $user = Auth::user();
    $article = Article::findOrFail($id);

    $existingVote = $article->userVotes()->where('user_id', $user->id)->first();

    if ($existingVote) {
        if ($existingVote->vote === -1) {
            $existingVote->delete();
        } else {
            $existingVote->update(['vote' => -1]);
        }
    } else {
        UserVote::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'vote' => -1,
        ]);
    }

    $article->load('userVotes');

    return response()->json([
        'totalVotes' => $article->userVotes->sum('vote'),
        'userVote' => -1,
    ]);
}

    
    
}
