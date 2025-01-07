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
        </div>

        <!-- User Articles -->
        <div class="user-articles">
            <h3>Articles Posted</h3>
            @if($user->articles->count() > 0)
                <ul>
                    @foreach($user->articles as $article)
                        <li>
                            <a href="{{ $article->link }}" target="_blank">{{ $article->title }}</a>
                            <p>Posted on: {{ $article->created_at->format('F j, Y') }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No articles posted yet.</p>
            @endif
        </div>
    </div>
@endsection
