@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/members.css') }}" rel="stylesheet">
@endsection

@section('title', 'Members')

@section('content')
    <h1>Members</h1>
    
    <!-- Search Bar and Group Filter -->
    <div class="search-and-filter">
        <div class="search-bar">
            <input type="text" id="search" placeholder="Search by name..." oninput="filterMembers()">
        </div>
        <div class="group-filter">
            <select id="groupFilter" onchange="filterMembers()">
                <option value="">All Groups</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="members-list">
        @foreach($users as $user)
            <div class="member-card" data-name="{{ $user->name }}" data-group="{{ $user->group->id }}">
                <a href="{{ route('members.show', $user->id) }}">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="avatar">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                    <p>Group: {{ $user->group->name ?? 'No Group' }}</p>
                </a>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
<script>
    // Function to filter members based on the search and group filter
    function filterMembers() {
        const searchQuery = document.getElementById('search').value.toLowerCase();
        const groupFilter = document.getElementById('groupFilter').value;
        const members = document.querySelectorAll('.member-card');

        members.forEach(member => {
            const name = member.getAttribute('data-name').toLowerCase();
            const group = member.getAttribute('data-group');
            
            const matchesSearch = name.includes(searchQuery);
            const matchesGroup = groupFilter === "" || group === groupFilter;

            if (matchesSearch && matchesGroup) {
                member.style.display = 'block';
            } else {
                member.style.display = 'none';
            }
        });
    }
</script>
@endsection
