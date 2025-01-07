

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/members.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'Members'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Members</h1>
    
    <!-- Search Bar and Group Filter -->
    <div class="search-and-filter">
        <div class="search-bar">
            <input type="text" id="search" placeholder="Search by name..." oninput="filterMembers()">
        </div>
        <div class="group-filter">
            <select id="groupFilter" onchange="filterMembers()">
                <option value="">All Groups</option>
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <div class="members-list">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="member-card" data-name="<?php echo e($user->name); ?>" data-group="<?php echo e($user->group->id); ?>">
                <a href="<?php echo e(route('members.show', $user->id)); ?>">
                    <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="<?php echo e($user->name); ?>" class="avatar">
                    <h3><?php echo e($user->name); ?></h3>
                    <p><?php echo e($user->email); ?></p>
                    <p>Group: <?php echo e($user->group->name ?? 'No Group'); ?></p>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Function to filter members based on the search and group filter
    function filterMembers() {
        const searchQuery = document.getElementById('search').value.toLowerCase();
        const groupFilter = document.getElementById('groupFilter').value;
        const members = document.querySelectorAll('.member-card');

        members.forEach(member => {
            const name = member.getAttribute('data-name').toLowerCase();
            const group = member.getAttribute('data-group');
            
            const matchesSearch = name.includes(searchQuery);
            const matchesGroup = groupFilter === "" || group === groupFilter;

            if (matchesSearch && matchesGroup) {
                member.style.display = 'block';
            } else {
                member.style.display = 'none';
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/members.blade.php ENDPATH**/ ?>