

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/news.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Latest Tech News</h1>

    <!-- Search Form -->
    <form action="<?php echo e(route('news')); ?>" method="GET" class="search-form">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search for news..." />
        <button type="submit">Search</button>
    </form>

    <!-- News Articles -->
    <div class="articles-list">
        <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="article">
                <?php if($article['urlToImage']): ?>
                    <img src="<?php echo e($article['urlToImage']); ?>" alt="<?php echo e($article['title']); ?>">
                <?php endif; ?>
                <h3><?php echo e($article['title']); ?></h3>
                <p><?php echo e(Str::limit($article['description'], 100)); ?></p>
                <a href="<?php echo e($article['url']); ?>" target="_blank">Read More</a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>

<!-- Pagination -->
<div class="pagination-container">
    <?php echo e($articles->links()); ?>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/news.blade.php ENDPATH**/ ?>