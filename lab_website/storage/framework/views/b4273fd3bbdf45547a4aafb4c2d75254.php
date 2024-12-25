

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/about.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/about.blade.php ENDPATH**/ ?>