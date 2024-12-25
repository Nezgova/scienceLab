<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ensure fields are arrays or valid JSON
        $user->interests = $user->interests ? json_decode($user->interests, true) : [];
        $user->specialties = $user->specialties ? json_decode($user->specialties, true) : [];

        // Update query to use 'author_id' instead of 'user_id'
        $articles = Article::where('author_id', $user->id)->get();

        return view('profile', compact('user', 'articles'));
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
    
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url', // Ensure it's a valid URL
        ]);
    
        $article->title = $request->title;
        $article->link = $request->link; // Use the link field instead of content
        $article->save();
    
        return redirect()->back()->with('success', 'Article updated successfully!');
    }
    
}
