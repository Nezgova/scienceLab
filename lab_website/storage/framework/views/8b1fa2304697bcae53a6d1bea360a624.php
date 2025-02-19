

<?php $__env->startSection('title', 'Profile'); ?>
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
            <img src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('attachments/default.png')); ?>" 
                alt="Profile Picture" 
                class="profile-pic-large">
        </div>

        <!-- Profile Form Fields -->
        <div class="profile-details">
            <div class="detail-item">
                <label>Email:</label>
                <p><?php echo e(Auth::user()->email); ?></p>
            </div>
            <div class="detail-item">
                <label>Password:</label>
                <p>********</p>
            </div>
            <div class="detail-item">
                <label>Interests:</label>
                <p><?php echo e(implode(', ', Auth::user()->interests ?? [])); ?></p>
            </div>
            <div class="detail-item">
                <label>Specialties:</label>
                <p><?php echo e(implode(', ', Auth::user()->specialties ?? [])); ?></p>
            </div>
            <div class="detail-item">
                <label>Research Group:</label>
                <p><?php echo e(Auth::user()->group ? Auth::user()->group->name : 'No group assigned'); ?></p>
            </div>
            <div class="detail-item">
                <label>Sex:</label>
                <p><?php echo e(Auth::user()->sex ?? 'Not set'); ?></p>
            </div>
            <div class="detail-item">
                <label>Description:</label>
                <p><?php echo e(Auth::user()->description ?? 'No description available.'); ?></p>
            </div>
        </div>

        <!-- Hidden Edit Form -->
        <div id="edit-form" style="display: none; margin-top: 20px;">
            <label>Edit Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*">

            <label>Edit Email</label>
            <input type="email" name="email" value="<?php echo e(Auth::user()->email); ?>">

            <label>Edit Password</label>
            <input type="password" name="password" placeholder="Enter a new password (optional)">

            <label>Edit Interests</label>
            <select name="interests[]" multiple>
                <?php $__currentLoopData = ['Technology', 'Art', 'Music', 'Sports', 'Travel']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($interest); ?>" 
                    <?php echo e(is_array(Auth::user()->interests) && in_array($interest, Auth::user()->interests) ? 'selected' : ''); ?>>
                    <?php echo e($interest); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label>Edit Specialties</label>
            <select name="specialties[]" multiple>
                <?php $__currentLoopData = ['Programming', 'Design', 'Writing', 'Marketing', 'Leadership']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($specialty); ?>" 
                    <?php echo e(is_array(Auth::user()->specialties) && in_array($specialty, Auth::user()->specialties) ? 'selected' : ''); ?>>
                    <?php echo e($specialty); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label>Edit Research Group</label>
            <select name="group_id">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($group->id); ?>" <?php echo e(Auth::user()->group_id == $group->id ? 'selected' : ''); ?>>
                    <?php echo e($group->name); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label>Edit Sex</label>
            <select name="sex">
                <option value="Male" <?php echo e(Auth::user()->sex == 'Male' ? 'selected' : ''); ?>>Male</option>
                <option value="Female" <?php echo e(Auth::user()->sex == 'Female' ? 'selected' : ''); ?>>Female</option>
                <option value="Other" <?php echo e(Auth::user()->sex == 'Other' ? 'selected' : ''); ?>>Other</option>
            </select>

            <label>Edit Description</label>
            <textarea name="description"><?php echo e(Auth::user()->description); ?></textarea>

            <button type="submit">Save Changes</button>
        </div>

        <!-- Center Buttons -->
        <div class="button-container">
            <button type="button" class="edit-button" onclick="toggleEditForm()">Edit Profile</button>
            <form method="POST" action="<?php echo e(route('profile.delete')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
            </form>
        </div>
    </form>
</div>


<!-- Articles Section -->
<div class="articles-section">
    <h2>Your Articles</h2>
    <?php if($articles->isEmpty()): ?>
    <p>You haven't written any articles yet.</p>
    <?php else: ?>
    <div class="articles-grid">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="article-card">
            <div class="article-content">
                <a href="<?php echo e($article->link); ?>" target="_blank">
                    <h3><?php echo e($article->title); ?></h3>
                </a>
                <p>Published on: <?php echo e($article->created_at->format('M d, Y')); ?></p>
            </div>
            <?php if($article->picture): ?>
            <img src="<?php echo e(asset('storage/' . $article->picture)); ?>" alt="Article Image" class="article-image">
            <?php endif; ?>
            <button type="button" class="edit-button" onclick="toggleArticleEditForm(<?php echo e($article->id); ?>)">Edit</button>

            <!-- Hidden Edit Form -->
            <div id="edit-form-<?php echo e($article->id); ?>" class="edit-article-form" style="display: none;">
                <form method="POST" action="<?php echo e(route('profile.articles.update', $article->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <label>Title</label>
                    <input type="text" name="title" value="<?php echo e($article->title); ?>" required>

                    <label>Link</label>
                    <input type="url" name="link" value="<?php echo e($article->link); ?>" required>

                    <label>Picture</label>
                    <input type="file" name="picture" accept="image/*">

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>

<script>
    function toggleEditForm() {
        const form = document.getElementById('edit-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleArticleEditForm(articleId) {
        const form = document.getElementById(`edit-form-${articleId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/profile.blade.php ENDPATH**/ ?>