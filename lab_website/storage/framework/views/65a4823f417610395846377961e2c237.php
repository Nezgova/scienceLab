

<?php $__env->startSection('content'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/home.blade.php ENDPATH**/ ?>