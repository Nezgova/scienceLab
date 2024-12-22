<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Specialty;  // Add this import to access the Specialty model
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

        // Create a new article
        Article::create([
            'title' => $request->title,
            'link' => $request->link,
            'author_id' => Auth::id(),
        ]);

        // Redirect back with a success message
        return Redirect::back()->with('message', 'Article submitted successfully!');
    }
}
