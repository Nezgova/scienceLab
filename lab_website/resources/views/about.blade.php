@extends('layouts.app')
@section('title', 'About Us') <!-- Set the page title -->
@section('styles')
    <link href="{{ asset('css/about.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Search and Filter Bar -->
    <form method="GET" action="{{ route('about') }}" class="search-form">
        <input type="text" name="search" placeholder="Search articles..." value="{{ request('search') }}">
        
        <!-- Group Filter -->
        <select name="group">
            <option value="">All Groups</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Search</button>
    </form>

    <!-- Post New Article Form -->
    <div class="post-article-form">
        <h2>Post a New Article</h2>
        <form method="POST" action="{{ route('about') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" name="link" required>
            </div>
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" name="picture" accept="image/*">
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
                        @if($article->picture)
                            <img src="{{ asset('storage/' . $article->picture) }}" alt="Article Picture">
                        @endif
                        <h3>{{ $article->title }}</h3>
                        <p>Posted by {{ $article->author->username }} on {{ $article->created_at->format('F j, Y') }}</p>
                        <a href="{{ $article->link }}" target="_blank">Read Article</a>
                        
                        <!-- Voting System -->
                        <div class="vote-container">
                            <form action="{{ route('articles.upvote', $article->id) }}" method="POST" class="vote-form" data-id="{{ $article->id }}">
                                @csrf
                                <button type="submit" class="vote-btn upvote-btn {{ $article->userVote(auth()->id())?->vote === 1 ? 'active-vote' : '' }}">Upvote</button>
                            </form>
                            <form action="{{ route('articles.downvote', $article->id) }}" method="POST" class="vote-form" data-id="{{ $article->id }}">
                                @csrf
                                <button type="submit" class="vote-btn downvote-btn {{ $article->userVote(auth()->id())?->vote === -1 ? 'active-vote' : '' }}">Downvote</button>
                            </form>
                        </div>
                        <p class="vote-count" data-id="{{ $article->id }}">
                            Votes: {{ $article->userVotes->sum('vote') }}
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
    document.addEventListener("DOMContentLoaded", () => {
        const voteForms = document.querySelectorAll(".vote-form");

        voteForms.forEach(form => {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const url = form.action;
                const articleId = form.dataset.id;
                const voteCountElement = document.querySelector(`.vote-count[data-id="${articleId}"]`);
                const container = form.closest(".vote-container");
                const upvoteBtn = container.querySelector(".upvote-btn");
                const downvoteBtn = container.querySelector(".downvote-btn");

                try {
                    const response = await fetch(url, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    });
                    const data = await response.json();

                    // Update vote count
                    voteCountElement.textContent = `Votes: ${data.totalVotes}`;

                    // Update button states
                    upvoteBtn.classList.toggle("active-vote", data.userVote === 1);
                    downvoteBtn.classList.toggle("active-vote", data.userVote === -1);
                } catch (error) {
                    console.error("Vote submission failed:", error);
                    alert("An error occurred while processing your vote.");
                }
            });
        });
    });
</script>
@endsection
