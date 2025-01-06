@extends('layouts.app')
@section('title', 'About Us') <!-- Set the page title -->
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
                        
                        <!-- Voting System -->
                        <div class="vote-container">
                            <!-- Upvote Button -->
                            <form action="{{ route('articles.upvote', $article->id) }}" method="POST" class="vote-form" data-id="{{ $article->id }}">
                                @csrf
                                <button type="submit" class="vote-btn upvote-btn" data-vote="upvote">Upvote</button>
                            </form>
                        
                            <!-- Downvote Button -->
                            <form action="{{ route('articles.downvote', $article->id) }}" method="POST" class="vote-form" data-id="{{ $article->id }}">
                                @csrf
                                <button type="submit" class="vote-btn downvote-btn" data-vote="downvote">Downvote</button>
                            </form>
                        </div>
                        
                        <!-- Vote Count -->
                        <p class="vote-count" data-id="{{ $article->id }}">
                            Votes: {{ $article->userVotes instanceof Illuminate\Database\Eloquent\Collection ? $article->userVotes->sum('vote') : 0 }}
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

@section('scripts')
<script>
    console.log("AJAX voting script loaded");

    document.addEventListener("DOMContentLoaded", () => {
        // Prevent the default form submission first
        const voteForms = document.querySelectorAll(".vote-form");
        voteForms.forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();  // This must be called first
    console.log("Form submission intercepted for form:", form);
                const formData = new FormData(form);
                const url = form.action;
                const articleId = form.getAttribute("data-id");
                const voteCountElement = document.querySelector(`.vote-count[data-id="${articleId}"]`);

                fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update vote count
                    voteCountElement.textContent = `Votes: ${data.totalVotes}`;

                    // Update button states
                    const container = form.closest(".vote-container");
                    const upvoteBtn = container.querySelector(".upvote-btn");
                    const downvoteBtn = container.querySelector(".downvote-btn");

                    upvoteBtn.classList.remove("active-vote");
                    downvoteBtn.classList.remove("active-vote");

                    if (data.userVote === 1) {
                        upvoteBtn.classList.add("active-vote");
                    } else if (data.userVote === -1) {
                        downvoteBtn.classList.add("active-vote");
                    }
                })
                .catch(error => {
                    console.error("Vote submission failed:", error);
                    alert("An error occurred while processing your vote.");
                });

                return false; // Extra prevention of form submission
            });
        });
    });
</script>
@endsection