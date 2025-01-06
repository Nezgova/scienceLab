<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Derive the username from the email
        $user->username = explode('@', $user->email)[0];

        // Fetch the top 3 articles with the highest votes
        $top_articles = Article::withCount(['userVotes as votes' => function ($query) {
            $query->select(DB::raw('SUM(vote)')); // Sum up the votes
        }])
        ->orderByDesc('votes') // Order by total votes
        ->take(3) // Limit to top 3
        ->get();

        return view('home', compact('user', 'top_articles'));
    }
}
