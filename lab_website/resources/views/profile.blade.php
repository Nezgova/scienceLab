@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1>Profile</h1>
    
    <!-- User Profile Section -->
    <div class="user-section-container">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture Section -->
            <div class="profile-picture-container">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('attachments/default.png') }}" 
                    alt="Profile Picture" 
                    class="profile-pic-large"
                >
                <input type="file" name="profile_picture" accept="image/*">
            </div>

            <!-- Profile Form Fields -->
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter a new password (optional)">

            <label>Interests</label>
            <select name="interests[]" multiple>
                @foreach(['Technology', 'Art', 'Music', 'Sports', 'Travel'] as $interest)
                    <option value="{{ $interest }}" 
                        {{ is_array($user->interests) && in_array($interest, $user->interests) ? 'selected' : '' }}>{{ $interest }}</option>
                @endforeach
            </select>
            
            <label>Specialties</label>
            <select name="specialties[]" multiple>
                @foreach(['Programming', 'Design', 'Writing', 'Marketing', 'Leadership'] as $specialty)
                    <option value="{{ $specialty }}" 
                        {{ is_array($user->specialties) && in_array($specialty, $user->specialties) ? 'selected' : '' }}>{{ $specialty }}</option>
                @endforeach
            </select>

            <label>Sex</label>
            <select name="sex">
                <option value="Male" {{ $user->sex == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user->sex == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $user->sex == 'Other' ? 'selected' : '' }}>Other</option>
            </select>

            <label>Description</label>
            <textarea name="description">{{ $user->description }}</textarea>

            <button type="submit">Save Changes</button>
        </form>

        <form method="POST" action="{{ route('profile.delete') }}">
            @csrf
            <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
        </form>
    </div>

    <!-- Articles Section -->
    <div class="articles-section">
        <h2>Your Articles</h2>
        @if ($articles->isEmpty())
            <p>You haven't written any articles yet.</p>
        @else
            <ul>
                @foreach($articles as $article)
                    <li class="article-item">
                        <h3>{{ $article->title }}</h3>
                        <p>Published on: {{ $article->created_at->format('M d, Y') }}</p>
                        <form method="POST" action="{{ route('profile.articles.update', $article->id) }}">
                            @csrf
                            <label>Title</label>
                            <input type="text" name="title" value="{{ $article->title }}" required>
                        
                            <label>Article Link</label>
                            <input type="url" name="link" value="{{ $article->link }}" required>
                        
                            <button type="submit">Update Article</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
