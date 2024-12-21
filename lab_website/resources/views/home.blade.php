<!-- resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/profile">Profile</a></li>
            <li class="logout">
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" title="Logout ({{ $user->username }})" class="profile-pic-container">
                        <img src="{{ asset($user->profile_picture ?: 'attachments/default.png') }}" alt="Profile Picture" class="profile-pic">
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
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
    </div>
</body>
</html>
