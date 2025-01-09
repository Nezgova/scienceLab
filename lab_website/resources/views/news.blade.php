@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/news.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>Latest Tech News</h1>

    <!-- Search Form -->
    <form action="{{ route('news') }}" method="GET" class="search-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for news..." />
        <button type="submit">Search</button>
    </form>

    <!-- News Articles -->
    <div class="articles-list">
        @forelse ($articles as $article)
            <div class="article">
                @if ($article['urlToImage'])
                    <img src="{{ $article['urlToImage'] }}" alt="{{ $article['title'] }}">
                @endif
                <h3>{{ $article['title'] }}</h3>
                <p>{{ Str::limit($article['description'], 100) }}</p>
                <a href="{{ $article['url'] }}" target="_blank">Read More</a>
            </div>
        @empty
            <p>No articles found.</p>
        @endforelse
    </div>

<!-- Pagination -->
<div class="pagination-container">
    {{ $articles->links() }}
</div>
</div>
@endsection
