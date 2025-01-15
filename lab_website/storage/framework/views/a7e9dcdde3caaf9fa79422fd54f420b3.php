<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?php echo e(asset('css/login.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset('images/LOGO.png')); ?>" type="image/x-icon">
</head>
<body>
    <div class="animated-background">
        <div class="particles">
            <?php for($i = 0; $i < 30; $i++): ?>
                <div class="particle" style="
                    left: <?php echo e(rand(0, 100)); ?>%;
                    top: <?php echo e(rand(0, 100)); ?>%;
                    animation-delay: -<?php echo e(rand(0, 30)); ?>s;
                "></div>
            <?php endfor; ?>
        </div>
    </div>
    <!-- Login Box -->
    <div class="login-box">
        <h2>Login</h2>

        <!-- Display Validation Errors -->
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

            <!-- Email -->
            <div class="user-box">
                <input type="email" name="email" id="email" required>
                <label>Email</label>
            </div>

            <!-- Password -->
            <div class="user-box">
                <input type="password" name="password" id="password" required>
                <label>Password</label>
            </div>

            <!-- Submit Button -->
            <a href="javascript:void(0);" onclick="this.closest('form').submit()">
                Login
                <span></span><span></span><span></span><span></span>
            </a>
        </form>

        <!-- Link to Register -->
        <p>Don't have an account? <a href="<?php echo e(route('register')); ?>">Register here</a>.</p>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/auth/login.blade.php ENDPATH**/ ?>