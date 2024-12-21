<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?php echo e(asset('css/login.css')); ?>" rel="stylesheet">
</head>
<body>
    <!-- Login box container -->
    <div class="login-box">
        <h2>Login</h2>

        <?php if($errors->any()): ?>
            <div style="color: red;">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?php echo e(route('login.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="user-box">
                <input type="email" name="email" id="email" required value="<?php echo e(old('email')); ?>">
                <label for="email">Email</label>
            </div>

            <div class="user-box">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>

            <!-- Submit Button with Animations -->
            <a href="javascript:void(0);" class="submit-button" onclick="document.querySelector('form').submit();">
                <span></span><span></span><span></span><span></span>Login
            </a>
        </form>

        <p>Don't have an account? <a href="<?php echo e(route('register')); ?>">Register here</a>.</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/auth/login.blade.php ENDPATH**/ ?>