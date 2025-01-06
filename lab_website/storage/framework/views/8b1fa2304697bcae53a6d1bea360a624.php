
<?php $__env->startSection('title', 'Profile'); ?> <!-- Set the page title -->
<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/profile.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1>Profile</h1>

    <div class="user-section-container">
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Profile Picture Section -->
            <div class="profile-picture-container">
                <img 
                    src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('attachments/default.png')); ?>" 
                    alt="Profile Picture" 
                    class="profile-pic-large"
                >
                <input type="file" name="profile_picture" accept="image/*"> <!-- Input for uploading a new image -->
            </div>

            <!-- Profile Form Fields -->
            <label>Email</label>
            <input type="email" name="email" value="<?php echo e(Auth::user()->email); ?>" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter a new password (optional)">

            <label>Interests</label>
            <select name="interests[]" multiple>
                <?php $__currentLoopData = ['Technology', 'Art', 'Music', 'Sports', 'Travel']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($interest); ?>" 
                        <?php echo e(is_array(Auth::user()->interests) && in_array($interest, Auth::user()->interests) ? 'selected' : ''); ?>><?php echo e($interest); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label>Specialties</label>
            <select name="specialties[]" multiple>
                <?php $__currentLoopData = ['Programming', 'Design', 'Writing', 'Marketing', 'Leadership']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($specialty); ?>" 
                        <?php echo e(is_array(Auth::user()->specialties) && in_array($specialty, Auth::user()->specialties) ? 'selected' : ''); ?>><?php echo e($specialty); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label>Sex</label>
            <select name="sex">
                <option value="Male" <?php echo e(Auth::user()->sex == 'Male' ? 'selected' : ''); ?>>Male</option>
                <option value="Female" <?php echo e(Auth::user()->sex == 'Female' ? 'selected' : ''); ?>>Female</option>
                <option value="Other" <?php echo e(Auth::user()->sex == 'Other' ? 'selected' : ''); ?>>Other</option>
            </select>

            <label>Description</label>
            <textarea name="description"><?php echo e(Auth::user()->description); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>

        <form method="POST" action="<?php echo e(route('profile.delete')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
        </form>
    </div>

    <!-- Articles Section -->
    <div class="articles-section">
        <h2>Your Articles</h2>
        <?php if($articles->isEmpty()): ?>
            <p>You haven't written any articles yet.</p>
        <?php else: ?>
            <ul>
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="article-item">
                        <h3><?php echo e($article->title); ?></h3>
                        <p>Published on: <?php echo e($article->created_at->format('M d, Y')); ?></p>
                        <form method="POST" action="<?php echo e(route('profile.articles.update', $article->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <label>Title</label>
                            <input type="text" name="title" value="<?php echo e($article->title); ?>" required>
                        
                            <label>Article Link</label>
                            <input type="url" name="link" value="<?php echo e($article->link); ?>" required>
                        
                            <button type="submit">Update Article</button>
                        </form>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/profile.blade.php ENDPATH**/ ?>