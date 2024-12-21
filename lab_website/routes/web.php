<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserVoteController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login.submit');
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected routes (requires login)
Route::middleware('auth')->group(function () {
    // Home page
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile routes
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
Route::post('/profile', [UserProfileController::class, 'update'])->name('profile');


    // Resourceful routes
    Route::resource('users', UserController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('votes', UserVoteController::class);
    Route::resource('specialties', SpecialtyController::class);
});
