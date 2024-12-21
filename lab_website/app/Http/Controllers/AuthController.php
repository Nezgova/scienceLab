<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed, redirect to the home page
        return redirect()->route('home');
    }

    // Authentication failed
    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}


    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
   // app/Http/Controllers/AuthController.php

public function register(Request $request)
{
    // Validate the input data
    $validated = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // Log the user in
    Auth::login($user);

    // Redirect to the login page after successful registration
    return redirect()->route('login');  // Redirect to the login page
}
// app/Http/Controllers/AuthController.php

public function logout(Request $request)
{
    Auth::logout(); // Log out the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate the CSRF token

    return redirect()->route('login'); // Redirect to the login page
}

}
