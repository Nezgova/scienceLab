@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/member_profile.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . ' Profile')

@section('content')
    <h1>{{ $user->name }}'s Profile</h1>

    <div class="user-profile">
        <!-- Profile Picture -->
        <div class="profile-info">
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="avatar">
            <p>Email: {{ $user->email }}</p>
            <p>Bio: {{ $user->description ?? 'No bio available.' }}</p>
            <p>Total Vote Count: {{ $user->articles->sum(function ($article) {
                return $article->upvotes()->count() - $article->downvotes()->count();
            }) }}</p> <!-- Total vote count -->
        </div>

        <!-- User Articles -->
        <div class="user-articles">
            <h3>Articles Posted</h3>
            @if($user->articles->count() > 0)
                <ul>
                    @foreach($user->articles as $article)
                        <li class="article-item">
                            <div class="article-card" 
                                 style="background-image: url('{{ asset('storage/' . $article->picture) }}');">
                                <div class="overlay">
                                    <a href="{{ $article->link }}" target="_blank">{{ $article->title }}</a>
                                    <p>Posted on: {{ $article->created_at->format('F j, Y') }}</p>
                                    <p>Vote Count: {{ $article->upvotes()->count() - $article->downvotes()->count() }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No articles posted yet.</p>
            @endif
        </div>
    </div>
@endsection
