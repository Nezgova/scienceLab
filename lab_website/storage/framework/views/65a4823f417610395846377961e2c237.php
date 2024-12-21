<!-- resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo e(asset('css/home.css')); ?>" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <!-- Navbar -->
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
                    <button type="submit" title="Logout (<?php echo e($user->username); ?>)" class="profile-pic-container">
                        <img src="<?php echo e(asset($user->profile_picture ?: 'attachments/default.png')); ?>" alt="Profile Picture" class="profile-pic">
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="image-container">
            <img src="<?php echo e(asset('images/lab-image.png')); ?>" alt="Lab Image">

        </div>
        <h1>Welcome to the Lab Portal</h1>
        <p>This is your home page where you can browse and upload research articles.</p>

        <!-- Scoreboard for Top Articles -->
        <h2>Top Voted Articles</h2>
        <div class="scoreboard">
            <?php if($top_articles->isEmpty()): ?>
                <p>No top articles available yet.</p>
            <?php else: ?>
                <ul>
                    <?php $__currentLoopData = $top_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e($article->link); ?>" target="_blank"><?php echo e($article->title); ?></a> - Votes: <?php echo e($article->votes); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/home.blade.php ENDPATH**/ ?>