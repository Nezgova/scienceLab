<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends Controller
{
    // Display articles, specialties, and the form to submit a new one
    public function about(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Retrieve articles, eager loading the author and votes relationships
        $articles = Article::with('author', 'votes') 
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%$search%");
            })
            ->orderByDesc('created_at')
            ->paginate(10); // Paginate the results for better performance

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
}
