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
        // Get the search term from the request
        $search = $request->input('search');
    
        // Retrieve articles, eager loading the author and votes relationships
        $articles = Article::with('author', 'votes') // Make sure votes is eager-loaded
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%$search%");
        })
        ->orderByDesc('created_at')
        ->paginate(10);
    
    
    
        // Fetch all specialties
        $specialties = Specialty::all();
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Return the view with articles, specialties, and user data
        return view('about', ['articles' => $articles, 'specialties' => $specialties, 'user' => $user]);
    }
    

    // Store a new article
    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
        ]);
    
        // Ensure the authenticated user is assigned as the author
        Article::create([
            'title' => $request->title,
            'link' => $request->link,
            'author_id' => Auth::id(),  // Ensure this is set to the logged-in user
        ]);
    
        // Redirect back with a success message
        return Redirect::back()->with('message', 'Article submitted successfully!');
    }

    // Handle the article update in the profile page
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Validate and update article
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        $article->update($validatedData);

        return redirect()->back()->with('success', 'Article updated successfully!');
    }

    // Handle the article deletion
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Ensure the user is the author before deleting
        if ($article->author_id === Auth::id()) {
            $article->delete();
            return redirect()->back()->with('success', 'Article deleted successfully!');
        }

        return redirect()->back()->with('error', 'You are not authorized to delete this article!');
    }

    // Handle the upvote action
    public function upvote($id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);

        // Check if the user has already voted
        $existingVote = $article->userVote($user->id);

        if ($existingVote) {
            // Update the user's vote if they have already voted
            if ($existingVote->vote === 1) {
                // Remove vote if it's already upvoted
                $existingVote->delete();
            } else {
                $existingVote->vote = 1;
                $existingVote->save();
            }
        } else {
            // Create a new upvote if the user hasn't voted yet
            UserVote::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'vote' => 1
            ]);
        }

        return redirect()->back()->with('message', 'Vote updated successfully!');
    }

    // Handle the downvote action
    public function downvote($id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);

        // Check if the user has already voted
        $existingVote = $article->userVote($user->id);

        if ($existingVote) {
            // Update the user's vote if they have already voted
            if ($existingVote->vote === -1) {
                // Remove vote if it's already downvoted
                $existingVote->delete();
            } else {
                $existingVote->vote = -1;
                $existingVote->save();
            }
        } else {
            // Create a new downvote if the user hasn't voted yet
            UserVote::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'vote' => -1
            ]);
        }

        return redirect()->back()->with('message', 'Vote updated successfully!');
    }
}
