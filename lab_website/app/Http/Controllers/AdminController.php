<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Group;

class AdminController extends Controller
{
    public function __construct()
    {
        // Protect the routes by checking if the user is an admin.
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->is_admin) {
                return $next($request);
            }
            return redirect('/home')->with('error', 'Access denied. You are not an admin.');
        });
    }

    public function index()
    {
        $users = User::with('group')->get();
        $articles = Article::with('author')->get();
        $statistics = User::withCount('articles')->get();
        $groups = Group::all(); // Fetch all groups

        return view('admin', compact('users', 'articles', 'statistics', 'groups'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ensure the 'name', 'email', and 'group_id' fields are being passed
        $data = $request->only(['name', 'email', 'group_id']);
        
        // Update the user
        $user->update($data);

        return back()->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = true;
        $user->save();

        return back()->with('success', 'User granted admin privileges.');
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->only(['title', 'link']));

        return back()->with('success', 'Article updated successfully.');
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return back()->with('success', 'Article deleted successfully.');
    }
}