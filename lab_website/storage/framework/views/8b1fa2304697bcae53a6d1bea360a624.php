<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="<?php echo e(route('profile')); ?>" class="active">Profile</a></li>
        </ul>
        <a href="<?php echo e(route('logout')); ?>">
            <img src="<?php echo e(asset('storage/' . (auth()->user()->profile_picture ?: 'profile_pictures/default.png'))); ?>" 
                 alt="Profile Picture" class="profile-pic-large">
        </a>
    </nav>

    <!-- Profile Section -->
    <div class="profile-container">
        <h1>Welcome, <?php echo e(auth()->user()->username); ?>!</h1>
        <img src="<?php echo e(asset('storage/' . (auth()->user()->profile_picture ?: 'profile_pictures/default_large.png'))); ?>" 
             alt="Profile Picture" class="profile-pic-large">

        <form method="POST" enctype="multipart/form-data" action="<?php echo e(route('profile')); ?>">
            <?php echo csrf_field(); ?>
            <!-- Profile Picture -->
            <label for="profile_picture">Change Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

            <!-- Description (Bio) -->
            <label for="description">Bio:</label>
            <textarea name="description" id="description" rows="5"><?php echo e(old('description', auth()->user()->description)); ?></textarea>

            <!-- Sex -->
            <label for="sex">Sex:</label>
            <select name="sex" id="sex">
                <option value="Male" <?php echo e(old('sex', auth()->user()->sex) === 'Male' ? 'selected' : ''); ?>>Male</option>
                <option value="Female" <?php echo e(old('sex', auth()->user()->sex) === 'Female' ? 'selected' : ''); ?>>Female</option>
                <option value="Other" <?php echo e(old('sex', auth()->user()->sex) === 'Other' ? 'selected' : ''); ?>>Other</option>
            </select>

            <!-- Specialties -->
            <label for="specialties">Specialties:</label>
            <select name="specialties[]" id="specialties" multiple>
                <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($specialty->name); ?>" 
                        <?php echo e(in_array($specialty->name, explode(',', auth()->user()->specialties)) ? 'selected' : ''); ?>>
                        <?php echo e($specialty->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Interests -->
            <label for="interests">Interests:</label>
            <select name="interests[]" id="interests" multiple>
                <?php $__currentLoopData = ['AI Research', 'Data Science', 'Cybersecurity', 'Machine Learning', 'Software Engineering']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($interest); ?>" 
                        <?php echo e(in_array($interest, explode(',', auth()->user()->interests)) ? 'selected' : ''); ?>>
                        <?php echo e($interest); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>

    <!-- Display User's Articles -->
    <div class="user-articles">
        <h2>Your Articles</h2>
        <?php if($articles->isEmpty()): ?>
            <p>You haven't posted any articles yet.</p>
        <?php else: ?>
            <ul>
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="article-item">
                        <h3><a href="<?php echo e($article->link); ?>" target="_blank"><?php echo e($article->title); ?></a></h3>
                        <p>Posted on: <?php echo e($article->created_at->format('F j, Y')); ?></p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/profile.blade.php ENDPATH**/ ?>