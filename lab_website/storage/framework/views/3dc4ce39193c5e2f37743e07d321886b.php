<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo e(asset('css/home.css')); ?>" rel="stylesheet">  <!-- Home CSS -->
        <link href="<?php echo e(asset('css/navbar.css')); ?>" rel="stylesheet"> <!-- Navbar CSS -->
        <?php echo $__env->yieldContent('styles'); ?> <!-- profile.css or other styles will load here -->

        <title><?php echo $__env->yieldContent('title', 'Home'); ?></title>
        
        <!-- CSRF Token for AJAX requests -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    </head>
    
    <body>
        <!-- Include the Navbar Component -->
        <?php if (isset($component)) { $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e = $attributes; } ?>
<?php $component = App\View\Components\Navbar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Navbar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $attributes = $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $component = $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Scripts Section -->
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script> <!-- Default JS -->
        <?php echo $__env->yieldContent('scripts'); ?> <!-- JavaScript from child views will load here -->
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/layouts/app.blade.php ENDPATH**/ ?>