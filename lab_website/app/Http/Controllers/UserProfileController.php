<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Models\Specialty;

class UserProfileController extends Controller
{
    // Show Profile Page
    public function show()
    {
        $user = Auth::user();
        $articles = Article::where('author_id', $user->id)->get();
        $specialties = Specialty::all();

        return view('profile', compact('user', 'articles', 'specialties'));
    }

    // Update Profile Logic
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
            'sex' => 'nullable|string|max:10',
            'specialties' => 'nullable|array',
            'interests' => 'nullable|array'
        ]);

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update other fields
        $user->description = $request->description;
        $user->sex = $request->sex;
        $user->specialties = implode(',', $request->specialties ?? []);
        $user->interests = implode(',', $request->interests ?? []);
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
