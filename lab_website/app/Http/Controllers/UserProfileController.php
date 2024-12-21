<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Specialty;  // Import the Specialty model

class UserProfileController extends Controller
{
    public function show()
    {
        // Fetch articles for the logged-in user
        $articles = Article::where('author_id', auth()->id())->get();

        // Fetch all specialties to display in the profile form
        $specialties = Specialty::all();  // Fetch all specialties

        // Get the authenticated user
        $user = auth()->user();

        // Pass the articles, specialties, and user to the view
        return view('profile', compact('articles', 'specialties', 'user'));
    }

    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'description' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sex' => 'nullable|string|max:10',
            'specialties' => 'nullable|array',  // Add validation for specialties
            'specialties.*' => 'string|distinct', // Ensure all specialties are distinct and strings
            'interests' => 'nullable|array', // Add validation for interests
            'interests.*' => 'string|distinct', // Ensure all interests are distinct and strings
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Update the profile description and sex
        if ($request->has('description')) {
            $user->description = $request->input('description');
        }

        if ($request->has('sex')) {
            $user->sex = $request->input('sex');
        }

        // Handle profile picture upload if exists
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $imagePath;
        }

        // Update the specialties (if provided)
        if ($request->has('specialties')) {
            $user->specialties = implode(',', $request->input('specialties')); // Store specialties as a comma-separated string
        }

        // Update the interests (if provided)
        if ($request->has('interests')) {
            $user->interests = implode(',', $request->input('interests')); // Store interests as a comma-separated string
        }

        // Save the changes
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}

