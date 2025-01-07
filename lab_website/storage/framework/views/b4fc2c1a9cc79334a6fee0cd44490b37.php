
<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/admin.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<h1>Admin Dashboard</h1>

<!-- Navigation Tabs -->
<div class="section-tabs">
    <button class="section-tab" onclick="showSection('users')">Users</button>
    <button class="section-tab" onclick="showSection('articles')">Articles</button>
    <button class="section-tab" onclick="showSection('statistics')">Statistics</button>
</div>

<!-- User Section -->
<div id="users" class="section-content hidden">
    <h2>Users</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Group</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->group->name ?? 'No Group'); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="admin-button update" onclick="toggleUserEditForm(<?php echo e($user->id); ?>)">Edit</button>

                        <!-- Edit Form -->
                        <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>" id="user-edit-form-<?php echo e($user->id); ?>" style="display: none;">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="name" value="<?php echo e($user->name); ?>" required>
                            <input type="email" name="email" value="<?php echo e($user->email); ?>" required>
                            <select name="group_id">
                                <option value="">No Group</option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>" <?php echo e($user->group_id == $group->id ? 'selected' : ''); ?>><?php echo e($group->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit" class="admin-button update">Save</button>
                        </form>

                        <!-- Delete Button -->
                        <form method="POST" action="<?php echo e(route('admin.users.delete', $user->id)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="admin-button delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <!-- Make Admin Button -->
                        <form method="POST" action="<?php echo e(route('admin.users.makeAdmin', $user->id)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="admin-button make-admin">Make Admin</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<!-- Article Section -->
<div id="articles" class="section-content hidden">
    <h2>Articles</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($article->title); ?></td>
                    <td><a href="<?php echo e($article->link); ?>" target="_blank">View</a></td>
                    <td><?php echo e($article->author->name ?? 'Unknown Author'); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="admin-button update" onclick="toggleArticleEditForm(<?php echo e($article->id); ?>)">Edit</button>

                        <!-- Edit Form -->
                        <form method="POST" action="<?php echo e(route('admin.articles.update', $article->id)); ?>" id="article-edit-form-<?php echo e($article->id); ?>" style="display: none;">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="title" value="<?php echo e($article->title); ?>" placeholder="Title" required>
                            <input type="url" name="link" value="<?php echo e($article->link); ?>" placeholder="Link" required>
                            <button type="submit" class="admin-button update">Save</button>
                        </form>

                        <!-- Delete Button -->
                        <form method="POST" action="<?php echo e(route('admin.articles.delete', $article->id)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="admin-button delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<!-- Statistics Section -->
<div id="statistics" class="section-content hidden">
    <h2>Statistics</h2>
    <canvas id="userArticlesChart"></canvas>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function toggleUserEditForm(userId) {
        const form = document.getElementById(`user-edit-form-${userId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleArticleEditForm(articleId) {
        const form = document.getElementById(`article-edit-form-${articleId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section-content');
        sections.forEach(section => section.classList.add('hidden'));
        document.getElementById(sectionId).classList.remove('hidden');
    }

    document.addEventListener("DOMContentLoaded", () => {
        const ctx = document.getElementById('userArticlesChart').getContext('2d');
        const userArticlesData = <?php echo json_encode($statistics->pluck('articles_count', 'name'), 512) ?>;
        const labels = Object.keys(userArticlesData);
        const data = Object.values(userArticlesData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Articles per User',
                    data: data,
                    backgroundColor: 'rgba(100, 255, 218, 0.5)',
                    borderColor: 'rgba(100, 255, 218, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/admin.blade.php ENDPATH**/ ?>