

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/member_profile.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', $user->name . ' Profile'); ?>

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($user->name); ?>'s Profile</h1>

    <div class="user-profile">
        <!-- Profile Picture -->
        <div class="profile-info">
            <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="<?php echo e($user->name); ?>" class="avatar">
            <p>Email: <?php echo e($user->email); ?></p>
            <p>Bio: <?php echo e($user->description ?? 'No bio available.'); ?></p>
        </div>

        <!-- User Articles -->
        <div class="user-articles">
            <h3>Articles Posted</h3>
            <?php if($user->articles->count() > 0): ?>
                <ul>
                    <?php $__currentLoopData = $user->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e($article->link); ?>" target="_blank"><?php echo e($article->title); ?></a>
                            <p>Posted on: <?php echo e($article->created_at->format('F j, Y')); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p>No articles posted yet.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/memberProfile.blade.php ENDPATH**/ ?>