<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="{{ route('profile') }}" class="active">Profile</a></li>
        </ul>
        <a href="{{ route('logout') }}">
            <img src="{{ asset('storage/' . (auth()->user()->profile_picture ?: 'profile_pictures/default.png')) }}" 
                 alt="Profile Picture" class="profile-pic-large">
        </a>
    </nav>

    <!-- Profile Section -->
    <div class="profile-container">
        <h1>Welcome, {{ auth()->user()->username }}!</h1>
        <img src="{{ asset('storage/' . (auth()->user()->profile_picture ?: 'profile_pictures/default_large.png')) }}" 
             alt="Profile Picture" class="profile-pic-large">

        <form method="POST" enctype="multipart/form-data" action="{{ route('profile') }}">
            @csrf
            <!-- Profile Picture -->
            <label for="profile_picture">Change Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

            <!-- Description (Bio) -->
            <label for="description">Bio:</label>
            <textarea name="description" id="description" rows="5">{{ old('description', auth()->user()->description) }}</textarea>

            <!-- Sex -->
            <label for="sex">Sex:</label>
            <select name="sex" id="sex">
                <option value="Male" {{ old('sex', auth()->user()->sex) === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex', auth()->user()->sex) === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('sex', auth()->user()->sex) === 'Other' ? 'selected' : '' }}>Other</option>
            </select>

            <!-- Specialties -->
            <label for="specialties">Specialties:</label>
            <select name="specialties[]" id="specialties" multiple>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->name }}" 
                        {{ in_array($specialty->name, explode(',', auth()->user()->specialties)) ? 'selected' : '' }}>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </select>

            <!-- Interests -->
            <label for="interests">Interests:</label>
            <select name="interests[]" id="interests" multiple>
                @foreach (['AI Research', 'Data Science', 'Cybersecurity', 'Machine Learning', 'Software Engineering'] as $interest)
                    <option value="{{ $interest }}" 
                        {{ in_array($interest, explode(',', auth()->user()->interests)) ? 'selected' : '' }}>
                        {{ $interest }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>

    <!-- Display User's Articles -->
    <div class="user-articles">
        <h2>Your Articles</h2>
        @if ($articles->isEmpty())
            <p>You haven't posted any articles yet.</p>
        @else
            <ul>
                @foreach ($articles as $article)
                    <li class="article-item">
                        <h3><a href="{{ $article->link }}" target="_blank">{{ $article->title }}</a></h3>
                        <p>Posted on: {{ $article->created_at->format('F j, Y') }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</body>
</html>
