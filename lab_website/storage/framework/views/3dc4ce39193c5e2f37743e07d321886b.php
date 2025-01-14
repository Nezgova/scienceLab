<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo e(asset('css/home.css')); ?>" rel="stylesheet">  <!-- Home CSS -->
        <link href="<?php echo e(asset('css/navbar.css')); ?>" rel="stylesheet"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Navbar CSS -->
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="<?php echo e(asset('/lab_website/resources/js/navbar.js')); ?>" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const emojiButton = document.getElementById('emojiButton');
                const emojiPicker = document.getElementById('emojiPicker');
                const messageTextarea = document.querySelector('textarea[name="message"]');
                const emojiGrid = document.querySelector('.emoji-grid');
            
                // Emoji list
                const emojis = ['😀', '😂', '🤣', '😊', '😍', '🥰', '😘', '😜', '😎', '🤔', '😴', '😷', 
                                '👍', '👎', '👋', '🙌', '👏', '🎉', '❤️', '💔', '💯', '✨', '🔥', '💫',
                                '😢', '😭', '😤', '😠', '🤮', '🤢', '🤕', '🤒', '😵', '🥴', '😰', '😨',
                                '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮'];
            
                // Populate emoji picker grid
                emojis.forEach(emoji => {
                    const emojiSpan = document.createElement('div');
                    emojiSpan.className = 'emoji-item';
                    emojiSpan.textContent = emoji;
                    emojiSpan.addEventListener('click', () => {
                        insertEmojiAtCursor(messageTextarea, emoji);
                    });
                    emojiGrid.appendChild(emojiSpan);
                });
            
                // Toggle emoji picker
                emojiButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    emojiPicker.classList.toggle('active');
                });
            
                // Close emoji picker when clicking outside
                document.addEventListener('click', (e) => {
                    if (!emojiPicker.contains(e.target) && e.target !== emojiButton) {
                        emojiPicker.classList.remove('active');
                    }
                });
            
                // Function to insert emoji at cursor in the textarea
                function insertEmojiAtCursor(textarea, emoji) {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + emoji + textarea.value.substring(end);
                    textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                    textarea.focus();
                }
            });
            </script>
        <?php echo $__env->yieldContent('scripts'); ?> <!-- JavaScript from child views will load here -->
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/layouts/app.blade.php ENDPATH**/ ?>