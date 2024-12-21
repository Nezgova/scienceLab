<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'profile_picture' => 'nullable|string',
            'description' => 'nullable|string',
            'sex' => 'nullable|string',
            'specialties' => 'nullable|string',
            'interests' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'email' => 'email|unique:users,email,' . $id,
            'username' => 'string|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'string',
            'profile_picture' => 'nullable|string',
            'description' => 'nullable|string',
            'sex' => 'nullable|string',
            'specialties' => 'nullable|string',
            'interests' => 'nullable|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
