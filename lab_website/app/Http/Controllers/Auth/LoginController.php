<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate form input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Check credentials
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Log the user in
            Auth::login($user);

            // Redirect based on the user's role
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard'); // You can define this route based on your admin dashboard
            }

            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
