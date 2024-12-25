@extends('layouts.app')

@section('content')
    <div class="image-container">
        <img src="{{ asset('images/lab-image.png') }}" alt="Lab Image">
    </div>
    <h1>Welcome to the Lab Portal</h1>
    <p>This is your home page where you can browse and upload research articles.</p>

    <!-- Scoreboard for Top Articles -->
    <h2>Top Voted Articles</h2>
    <div class="scoreboard">
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
