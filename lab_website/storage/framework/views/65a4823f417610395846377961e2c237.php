

<?php $__env->startSection('content'); ?>

    <!-- Hero Section -->
    <div class="image-container">
        <img src="<?php echo e(asset('images/lab-image.png')); ?>" alt="Lab Image">
    </div>
    <h1>Welcome to the Lab Portal</h1>
    <p>This is your home page where you can browse and upload research articles.</p>

    <!-- Description Section -->
    <div class="page-descriptions">
        <h2>Explore the Portal</h2>
        <div class="description-item">
            <i class="fas fa-home"></i>
            <div>
                <h3>Home</h3>
                <p>Your starting point to explore everything in the portal.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-newspaper"></i>
            <div>
                <h3>Articles</h3>
                <p>Browse and read research articles shared by members.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-users"></i>
            <div>
                <h3>Members</h3>
                <p>Connect with researchers and contributors.</p>
            </div>
        </div>
        <div class="description-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>Messages</h3>
                <p>Send and receive messages to collaborate on research.</p>
            </div>
        </div>

        <!-- Admin Section (Only visible to admins) -->
        <?php if(Auth::user() && Auth::user()->is_admin): ?>
            <div class="description-item">
                <i class="fas fa-cogs"></i>
                <div>
                    <h3>Admin</h3>
                    <p>Manage the portal and its content (Admin only).</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scoreboard for Top Articles -->
    <div class="scoreboard">
        <h2>Top Voted Articles</h2>
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