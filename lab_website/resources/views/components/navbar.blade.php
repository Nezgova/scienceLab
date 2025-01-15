<nav class="navbar">
    <div class="logo">Lab Portal</div>
    
    <div class="nav-wrapper">
        <ul class="nav-links">
            <span class="nav-indicator"></span>
            
            <li>
                <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            
            <li>
                <a href="/about" class="{{ Request::is('about') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Articles</span>
                </a>
            </li>

            <li>
                <a href="{{ route('news') }}" class="{{ Request::routeIs('news') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>News</span>
                </a>
            </li>

            <li>
                <a href="/members" class="{{ Request::is('members') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </a>
            </li>

            <li>
                <a href="{{ route('messages.index') }}" class="{{ Request::routeIs('messages.index') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>
        </ul>

        <div class="nav-right">
            <div class="profile-dropdown">
                <button class="profile-btn" title="Profile Menu">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                        alt="Profile"
                    >
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/profile"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    @if(Auth::user() && Auth::user()->is_admin)
                        <li>
                            <a href="{{ route('admin.index') }}"><i class="fas fa-cogs"></i> Admin</a>
                        </li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            
        </div>
</nav>
