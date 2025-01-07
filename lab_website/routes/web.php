<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserVoteController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;


// Redirect / to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// About routes - Article management on the about page
Route::get('/about', [ArticleController::class, 'about'])->name('about');
Route::post('/about', [ArticleController::class, 'store'])->middleware('auth');

// Voting routes (Upvote and Downvote)
Route::post('/articles/{id}/upvote', [ArticleController::class, 'upvote'])->name('articles.upvote');
Route::post('/articles/{id}/downvote', [ArticleController::class, 'downvote'])->name('articles.downvote');

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
    // Home page route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile routes
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile'); // View Profile page
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update'); // Update profile
    Route::post('/profile/delete', [UserProfileController::class, 'deleteAccount'])->name('profile.delete'); // Delete account
    Route::post('/profile/articles/{id}/update', [UserProfileController::class, 'updateArticle'])->name('profile.articles.update');


    // Article management within profile
    Route::post('/profile/articles/{id}/update', [UserProfileController::class, 'updateArticle'])->name('profile.articles.update'); // Update article
    Route::delete('/profile/articles/{id}', [UserProfileController::class, 'deleteArticle'])->name('profile.articles.delete'); // Delete article

    // Specialty routes
    Route::resource('specialties', SpecialtyController::class);
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // User Management
    Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{id}/make-admin', [AdminController::class, 'makeAdmin'])->name('users.makeAdmin');

    // Article Management
    Route::post('/articles/{id}/update', [AdminController::class, 'updateArticle'])->name('articles.update');
    Route::post('/articles/{id}/delete', [AdminController::class, 'deleteArticle'])->name('articles.delete');
});

// Members Page Routes
Route::get('/members', [UserController::class, 'index'])->name('members.index');
Route::get('/members/{id}', [UserController::class, 'show'])->name('members.show');
