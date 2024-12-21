<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Derive the username from the email
        $user->username = explode('@', $user->email)[0];

        // Fetch top articles (if applicable)
        $top_articles = \App\Models\Article::orderBy('votes', 'desc')->take(3)->get();

        return view('home', compact('user', 'top_articles'));
    }
}

