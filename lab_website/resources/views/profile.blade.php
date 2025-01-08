@extends('layouts.app')

@section('title', 'Profile')
@section('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<h1>Profile</h1>

<div class="user-section-container">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Profile Picture Section -->
        <div class="profile-picture-container">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('attachments/default.png') }}" 
                alt="Profile Picture" 
                class="profile-pic-large">
        </div>

        <!-- Profile Form Fields -->
        <div class="profile-details">
            <!-- Profile Information -->
            <div class="detail-item">
                <label>Email:</label>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <div class="detail-item">
                <label>Password:</label>
                <p>********</p>
            </div>
            <div class="detail-item">
                <label>Interests:</label>
                <p>{{ implode(', ', Auth::user()->interests ?? []) }}</p>
            </div>
            <div class="detail-item">
                <label>Specialties:</label>
                <p>{{ implode(', ', Auth::user()->specialties ?? []) }}</p>
            </div>
            <div class="detail-item">
                <label>Research Group:</label>
                <p>{{ Auth::user()->group ? Auth::user()->group->name : 'No group assigned' }}</p>
            </div>
            <div class="detail-item">
                <label>Sex:</label>
                <p>{{ Auth::user()->sex ?? 'Not set' }}</p>
            </div>
            <div class="detail-item">
                <label>Description:</label>
                <p>{{ Auth::user()->description ?? 'No description available.' }}</p>
            </div>
        </div>

        <button type="button" class="edit-button" onclick="toggleEditForm()">Edit Profile</button>

        <!-- Hidden Edit Form -->
        <div id="edit-form" style="display: none;">
            <label>Edit Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*">
            <label>Edit Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}">

            <label>Edit Password</label>
            <input type="password" name="password" placeholder="Enter a new password (optional)">

            <label>Edit Interests</label>
            <select name="interests[]" multiple>
                @foreach(['Technology', 'Art', 'Music', 'Sports', 'Travel'] as $interest)
                <option value="{{ $interest }}" 
                    {{ is_array(Auth::user()->interests) && in_array($interest, Auth::user()->interests) ? 'selected' : '' }}>
                    {{ $interest }}
                </option>
                @endforeach
            </select>

            <label>Edit Specialties</label>
            <select name="specialties[]" multiple>
                @foreach(['Programming', 'Design', 'Writing', 'Marketing', 'Leadership'] as $specialty)
                <option value="{{ $specialty }}" 
                    {{ is_array(Auth::user()->specialties) && in_array($specialty, Auth::user()->specialties) ? 'selected' : '' }}>
                    {{ $specialty }}
                </option>
                @endforeach
            </select>

            <label>Edit Research Group</label>
            <select name="group_id">
                @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ Auth::user()->group_id == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
                @endforeach
            </select>

            <label>Edit Sex</label>
            <select name="sex">
                <option value="Male" {{ Auth::user()->sex == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ Auth::user()->sex == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ Auth::user()->sex == 'Other' ? 'selected' : '' }}>Other</option>
            </select>

            <label>Edit Description</label>
            <textarea name="description">{{ Auth::user()->description }}</textarea>

            <button type="submit">Save Changes</button>
        </div>
    </form>

    <form method="POST" action="{{ route('profile.delete') }}">
        @csrf
        <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
    </form>
</div>

<!-- Articles Section -->
<div class="articles-section">
    <h2>Your Articles</h2>
    @if ($articles->isEmpty())
    <p>You haven't written any articles yet.</p>
    @else
    <div class="articles-grid">
        @foreach($articles as $article)
        <div class="article-card">
            <div class="article-content">
                <a href="{{ $article->link }}" target="_blank">
                    <h3>{{ $article->title }}</h3>
                </a>
                <p>Published on: {{ $article->created_at->format('M d, Y') }}</p>
            </div>
            @if($article->picture)
            <img src="{{ asset('storage/' . $article->picture) }}" alt="Article Image" class="article-image">
            @endif
            <button type="button" class="edit-button" onclick="toggleArticleEditForm({{ $article->id }})">Edit</button>

            <!-- Hidden Edit Form -->
            <div id="edit-form-{{ $article->id }}" class="edit-article-form" style="display: none;">
                <form method="POST" action="{{ route('profile.articles.update', $article->id) }}" enctype="multipart/form-data">
                    @csrf
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $article->title }}" required>

                    <label>Link</label>
                    <input type="url" name="link" value="{{ $article->link }}" required>

                    <label>Picture</label>
                    <input type="file" name="picture" accept="image/*">

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    function toggleEditForm() {
        const form = document.getElementById('edit-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleArticleEditForm(articleId) {
        const form = document.getElementById(`edit-form-${articleId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
