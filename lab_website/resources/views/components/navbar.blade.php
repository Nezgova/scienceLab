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
                <button type="submit" title="Logout ({{ explode('@', Auth::user()->email)[0] }})" class="navbar-avatar">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('attachments/default.png') }}" alt="Profile Picture" class="avatar-pic">
                </button>
            </form>
        </li>
    </ul>
</nav>
