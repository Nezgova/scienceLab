<nav class="navbar">
    <div class="logo">Lab Portal</div>
    
    <div class="nav-wrapper">
        <ul class="nav-links">
            <span class="nav-indicator"></span>
            
            <li>
                <a href="<?php echo e(route('home')); ?>" class="<?php echo e(Request::routeIs('home') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            
            <li>
                <a href="/about" class="<?php echo e(Request::is('about') ? 'active' : ''); ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Articles</span>
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('news')); ?>" class="<?php echo e(Request::routeIs('news') ? 'active' : ''); ?>">
                    <i class="fas fa-bullhorn"></i>
                    <span>News</span>
                </a>
            </li>

            <li>
                <a href="/members" class="<?php echo e(Request::is('members') ? 'active' : ''); ?>">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('messages.index')); ?>" class="<?php echo e(Request::routeIs('messages.index') ? 'active' : ''); ?>">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>
        </ul>

        <div class="nav-right">
            <div class="profile-dropdown">
                <button class="profile-btn" title="Profile Menu">
                    <img 
                        src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png')); ?>" 
                        alt="Profile"
                    >
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/profile"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <?php if(Auth::user() && Auth::user()->is_admin): ?>
                        <li>
                            <a href="<?php echo e(route('admin.index')); ?>"><i class="fas fa-cogs"></i> Admin</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            
        </div>
</nav>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/components/navbar.blade.php ENDPATH**/ ?>