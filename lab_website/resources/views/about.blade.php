@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/about.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1>About Us</h1>
    <p>Welcome to the Lab Portal! This is a platform where PhD students and researchers can share and explore research articles.</p>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('about') }}" class="search-form">
        <input type="text" name="search" placeholder="Search articles..." value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    <!-- Post New Article Form -->
    <div class="post-article-form">
        <h2>Post a New Article</h2>
        <form method="POST" action="{{ route('about') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" name="link" required>
            </div>
            <button type="submit">Post Article</button>
        </form>
    </div>

    <!-- Display All Articles as Cards -->
    <div class="articles-section">
        <h2>All Articles</h2>
        <div class="articles-list">
            @if($articles->count())
                @foreach($articles as $article)
                    <div class="article">
                        <h3>{{ $article->title }}</h3>
                        <p>Posted by {{ $article->author->username }} on {{ $article->created_at->format('F j, Y') }}</p>
                        <a href="{{ $article->link }}" target="_blank">Read Article</a>
                        
                        <!-- Voting Buttons -->
                        <div class="vote-container">
                            <form action="{{ route('votes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <button type="submit" name="vote" value="1" class="vote-btn">Upvote</button>
                            </form>
                            <form action="{{ route('votes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <button type="submit" name="vote" value="-1" class="vote-btn">Downvote</button>
                            </form>
                        </div>
                        <p class="vote-count">
                            Votes: 
                            @php
                                // Ensure votes is loaded as a collection, or set to an empty array if not
                                $totalVotes = $article->votes ? $article->votes->sum('vote') : 0;
                            @endphp
                            {{ $totalVotes }}
                        </p>
                        
                        
                    </div>
                @endforeach
            @else
                <p>No articles found.</p>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $articles->links() }}
    </div>
@endsection
