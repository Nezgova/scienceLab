<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;


class UserProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $groups = Group::all(); // Fetch all groups

    // Ensure fields are arrays or valid JSON
    $user->interests = $user->interests ? json_decode($user->interests, true) : [];
    $user->specialties = $user->specialties ? json_decode($user->specialties, true) : [];

    $articles = Article::where('author_id', $user->id)->get();

    return view('profile', compact('user', 'articles', 'groups'));
}


    public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validate input
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Allow image uploads
        'interests' => 'nullable|array',
        'specialties' => 'nullable|array',
        'sex' => 'nullable|string',
        'description' => 'nullable|string|max:500',
        'group_id' => 'nullable|exists:groups,id',
    ]);

    // Update the user's email
    $user->email = $request->email;

    // Update the password if provided
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Check if a file is being uploaded
        if ($request->file('profile_picture')->isValid()) {
            // Proceed with saving the file
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        } else {
            return back()->withErrors(['profile_picture' => 'The uploaded file is not valid.']);
        }
    }
    
    

    // Save other profile fields
    $user->interests = json_encode($request->interests);
    $user->specialties = json_encode($request->specialties);
    $user->sex = $request->sex;
    $user->description = $request->description;
    $user->group_id = $request->group_id;

    // Save the updated user details
    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}


    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/')->with('success', 'Account deleted successfully.');
    }

    public function updateArticle(Request $request, $id)
{
    $article = Article::findOrFail($id);

    // Ensure the user owns the article
    if ($article->author_id !== Auth::id()) {
        return redirect()->back()->with('error', 'You are not authorized to edit this article.');
    }

    // Validate the input
    $request->validate([
        'title' => 'required|string|max:255',
        'link' => 'required|url',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate the uploaded image
    ]);

    // Update article fields
    $article->title = $request->title;
    $article->link = $request->link;

    // Handle the picture upload
    if ($request->hasFile('picture')) {
        // Delete the old picture if it exists
        if ($article->picture && Storage::disk('public')->exists($article->picture)) {
            Storage::disk('public')->delete($article->picture);
        }

        // Store the new picture
        $path = $request->file('picture')->store('article_pictures', 'public');
        $article->picture = $path;
    }

    // Save the updated article
    $article->save();

    return redirect()->back()->with('success', 'Article updated successfully!');
}

    
}
