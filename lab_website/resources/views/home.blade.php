@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <div class="image-container">
        <img src="{{ asset('images/lab-image.png') }}" alt="Lab Image">
    </div>
    <h1>Welcome to the Lab Portal</h1>

    <!-- Description Section -->
    <div class="page-descriptions">
        <h2>Explore the Portal</h2>
        <div class="description-item">
            <i class="fas fa-home"></i>
            <div>
                <h3>Home</h3>
                <p>Your starting point to explore everything in the portal.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-newspaper"></i>
            <div>
                <h3>Articles</h3>
                <p>Browse and read research articles shared by members.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-users"></i>
            <div>
                <h3>Members</h3>
                <p>Connect with researchers and contributors.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>Messages</h3>
                <p>Send and receive messages to collaborate on research.</p>
            </div>
        </div>

        <!-- Admin Section (Only visible to admins) -->
        @if(Auth::user() && Auth::user()->is_admin)
            <div class="description-item">
                <i class="fas fa-cogs"></i>
                <div>
                    <h3>Admin</h3>
                    <p>Manage the portal and its content (Admin only).</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Scoreboard for Top Articles -->
    <div class="scoreboard">
        <h2>Top Voted Articles</h2>
        @if ($top_articles->isEmpty())
            <p>No top articles available yet.</p>
        @else
            <ul>
                @foreach ($top_articles as $article)
                    <li>
                        <a href="{{ $article->link }}" target="_blank">{{ $article->title }}</a> - Votes: {{ $article->votes }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
