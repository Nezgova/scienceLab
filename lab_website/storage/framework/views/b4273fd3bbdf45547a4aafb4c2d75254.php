<!-- resources/views/about.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo e(asset('css/about.css')); ?>" rel="stylesheet">
    <title>About</title>
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
        <h1>About Us</h1>
        <p>Welcome to the Lab Portal! This is a platform where PhD students and researchers can share and explore research articles.</p>

        <!-- Search Bar -->
        <form method="GET" action="<?php echo e(route('about')); ?>" class="search-form">
            <input type="text" name="search" placeholder="Search articles..." value="<?php echo e(request('search')); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Post New Article Form -->
        <div class="post-article-form">
            <h2>Post a New Article</h2>
            <form method="POST" action="<?php echo e(route('about')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="url" name="link" required>
                </div>
                <button type="submit">Post Article</button>
            </form>
        </div>

        <!-- Display All Articles as Cards -->
        <div class="articles-section">
            <h2>All Articles</h2>
            <div class="articles-list">
                <?php if($articles->count()): ?>
                    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="article">
                            <h3><?php echo e($article->title); ?></h3>
                            <p>Posted by <?php echo e($article->author->username); ?> on <?php echo e($article->created_at->format('F j, Y')); ?></p>
                            <a href="<?php echo e($article->link); ?>" target="_blank">Read Article</a>
                            <!-- Voting Buttons -->
                            <div class="vote-container">
                                <button class="vote-btn">Upvote</button>
                                <button class="vote-btn">Downvote</button>
                            </div>
                            <p class="vote-count">Votes: <?php echo e($article->votes); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p>No articles found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php echo e($articles->links()); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/about.blade.php ENDPATH**/ ?>