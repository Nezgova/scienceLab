<!-- resources/views/components/dropdown.blade.php -->
<div class="relative">
    <button <?php echo e($trigger->attributes->merge(['class' => 'dropdown-trigger'])); ?>>
        <?php echo e($trigger); ?>

    </button>

    <div class="dropdown-content">
        <?php echo e($content); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/components/dropdown.blade.php ENDPATH**/ ?>