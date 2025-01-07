<nav class="navbar">
    <div class="logo">Lab Portal</div>
    <ul class="nav-links">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li><a href="/about">About</a></li> 

        <!-- Admin Section - Visible Only to Admins -->
        <?php if(Auth::user() && Auth::user()->is_admin): ?>
            <li><a href="<?php echo e(route('admin.index')); ?>">Admin</a></li>
        <?php endif; ?>

        <!-- Members Page Link -->
        <li><a href="/members">Members</a></li>

        <li><a href="/profile">Profile</a></li>

        <li class="logout">
            <!-- Logout Form -->
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" title="Logout (<?php echo e(explode('@', Auth::user()->email)[0]); ?>)" class="navbar-avatar">
                    <img src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('attachments/default.png')); ?>" alt="Profile Picture" class="avatar-pic">
                </button>
            </form>
        </li>
    </ul>
</nav>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/components/navbar.blade.php ENDPATH**/ ?>