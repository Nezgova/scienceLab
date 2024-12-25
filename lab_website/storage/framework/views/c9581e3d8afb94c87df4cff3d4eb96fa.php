<nav class="navbar">
    <div class="logo">Lab Portal</div>
    <ul class="nav-links">
        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/profile">Profile</a></li>
        <li class="logout">
            <!-- Logout Form -->
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" title="Logout (<?php echo e(explode('@', $user->email)[0]); ?>)" class="navbar-avatar">
                    <!-- Ensure the correct path is used for the profile picture -->
                    <img src="<?php echo e($user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('attachments/default.png')); ?>" alt="Profile Picture" class="avatar-pic">
                </button>
            </form>
        </li>
    </ul>
</nav>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/components/navbar.blade.php ENDPATH**/ ?>