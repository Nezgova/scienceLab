@extends('layouts.app')
@section('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('title', 'Admin Dashboard')

@section('content')
<h1>Admin Dashboard</h1>

<!-- Navigation Tabs -->
<div class="section-tabs">
    <button class="section-tab" onclick="showSection('users')">Users</button>
    <button class="section-tab" onclick="showSection('articles')">Articles</button>
    <button class="section-tab" onclick="showSection('statistics')">Statistics</button>
</div>

<!-- User Section -->
<div id="users" class="section-content hidden">
    <h2>Users</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Group</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->group->name ?? 'No Group' }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="admin-button update" onclick="toggleUserEditForm({{ $user->id }})">Edit</button>

                        <!-- Edit Form -->
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" id="user-edit-form-{{ $user->id }}" style="display: none;">
                            @csrf
                            <input type="text" name="name" value="{{ $user->name }}" required>
                            <input type="email" name="email" value="{{ $user->email }}" required>
                            <select name="group_id">
                                <option value="">No Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ $user->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="admin-button update">Save</button>
                        </form>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="admin-button delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <!-- Make Admin Button -->
                        <form method="POST" action="{{ route('admin.users.makeAdmin', $user->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="admin-button make-admin">Make Admin</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Article Section -->
<div id="articles" class="section-content hidden">
    <h2>Articles</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td><a href="{{ $article->link }}" target="_blank">View</a></td>
                    <td>{{ $article->author->name ?? 'Unknown Author' }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="admin-button update" onclick="toggleArticleEditForm({{ $article->id }})">Edit</button>

                        <!-- Edit Form -->
                        <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" id="article-edit-form-{{ $article->id }}" style="display: none;">
                            @csrf
                            <input type="text" name="title" value="{{ $article->title }}" placeholder="Title" required>
                            <input type="url" name="link" value="{{ $article->link }}" placeholder="Link" required>
                            <button type="submit" class="admin-button update">Save</button>
                        </form>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.articles.delete', $article->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="admin-button delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Statistics Section -->
<div id="statistics" class="section-content hidden">
    <h2>Statistics</h2>
    <canvas id="userArticlesChart"></canvas>
</div>
@endsection

@section('scripts')
<script>
    function toggleUserEditForm(userId) {
        const form = document.getElementById(`user-edit-form-${userId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleArticleEditForm(articleId) {
        const form = document.getElementById(`article-edit-form-${articleId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section-content');
        sections.forEach(section => section.classList.add('hidden'));
        document.getElementById(sectionId).classList.remove('hidden');
    }

    document.addEventListener("DOMContentLoaded", () => {
        const ctx = document.getElementById('userArticlesChart').getContext('2d');
        const userArticlesData = @json($statistics->pluck('articles_count', 'name'));
        const labels = Object.keys(userArticlesData);
        const data = Object.values(userArticlesData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Articles per User',
                    data: data,
                    backgroundColor: 'rgba(100, 255, 218, 0.5)',
                    borderColor: 'rgba(100, 255, 218, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
