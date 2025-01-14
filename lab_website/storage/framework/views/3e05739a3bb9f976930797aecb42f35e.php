<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/messages.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', isset($receiver) ? "Chat with {$receiver->name}" : 'Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="messages-container">
    
    <?php if(!isset($receiver)): ?>
        <div class="chat-list">
            <h2>Your Chats</h2>
            <?php if($chats->isEmpty()): ?>
                <p>No active chats found. Start a new conversation!</p>
            <?php else: ?>
                <ul>
                    <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userId => $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $chatUser = $messages->first()->sender_id === auth()->id()
                                ? $messages->first()->receiver
                                : $messages->first()->sender;
                        ?>
                        <li>
                            <a href="<?php echo e(route('messages.chat', ['receiver' => $chatUser->id])); ?>" class="chat-link">
                                <img src="<?php echo e(asset('storage/' . $chatUser->profile_picture)); ?>" alt="<?php echo e($chatUser->name); ?>" class="avatar">
                                <div class="chat-info">
                                    <span class="name"><?php echo e($chatUser->name); ?></span>
                                    <span class="last-message"><?php echo e(Str::limit($messages->last()->message, 30)); ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php else: ?>
        
        <div class="chat-messages">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="message <?php echo e($message->sender_id === auth()->id() ? 'sent' : 'received'); ?>">
                    <span class="sender"><?php echo e($message->sender_id === auth()->id() ? 'You' : $message->sender->name); ?></span>
                    <p><?php echo e($message->message); ?></p>
                    <small class="timestamp"><?php echo e($message->created_at->format('H:i')); ?></small>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No messages yet. Start the conversation!</p>
            <?php endif; ?>
        </div>
        
        <form action="<?php echo e(route('messages.store')); ?>" method="POST" class="chat-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="receiver_id" value="<?php echo e($receiver->id); ?>">
            <textarea name="message" placeholder="Type your message..." required></textarea>
            <button type="button" class="emoji-button" id="emojiButton">
                <i class="far fa-smile"></i>
            </button>
            <div class="emoji-picker" id="emojiPicker">
                <div class="emoji-grid">
                    <!-- Emojis will be dynamically inserted -->
                </div>
            </div>
            <button type="submit">Send</button>
        </form>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/messages.blade.php ENDPATH**/ ?>