<?php $__env->startSection('title', 'About Us'); ?> <!-- Set the page title -->
<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/about.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Search and Filter Bar -->
    <form method="GET" action="<?php echo e(route('about')); ?>" class="search-form">
        <input type="text" name="search" placeholder="Search articles..." value="<?php echo e(request('search')); ?>">
        
        <!-- Group Filter -->
        <select name="group">
            <option value="">All Groups</option>
            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($group->id); ?>" <?php echo e(request('group') == $group->id ? 'selected' : ''); ?>>
                    <?php echo e($group->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit">Search</button>
    </form>

    <!-- Post New Article Form -->
    <!-- Add Article Button and Form -->
<div class="post-article-container">
    <button id="toggleArticleForm" class="toggle-form-btn">Add Article</button>
    
    <div class="post-article-form" id="articleForm" style="display: none;">
        <h2>Post a New Article</h2>
        <form method="POST" action="<?php echo e(route('about')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" name="link" required>
            </div>
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" name="picture" accept="image/*">
            </div>
            <button type="submit">Post Article</button>
        </form>
    </div>
</div>

    <!-- Display All Articles as Cards -->
    <div class="articles-section">
        <h2>All Articles</h2>
        <div class="articles-list">
            <?php if($articles->count()): ?>
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="article">
                        <?php if($article->picture): ?>
                            <img src="<?php echo e(asset('storage/' . $article->picture)); ?>" alt="Article Picture">
                        <?php endif; ?>
                        <h3><?php echo e($article->title); ?></h3>
                        <p>Posted by <?php echo e($article->author->username); ?> on <?php echo e($article->created_at->format('F j, Y')); ?></p>
                        <a href="<?php echo e($article->link); ?>" target="_blank">Read Article</a>
                        
                        <!-- Voting System -->
                        <div class="vote-container">
                            <form action="<?php echo e(route('articles.upvote', $article->id)); ?>" method="POST" class="vote-form" data-id="<?php echo e($article->id); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="vote-btn upvote-btn <?php echo e($article->userVote(auth()->id())?->vote === 1 ? 'active-vote' : ''); ?>">Upvote</button>
                            </form>
                            <form action="<?php echo e(route('articles.downvote', $article->id)); ?>" method="POST" class="vote-form" data-id="<?php echo e($article->id); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="vote-btn downvote-btn <?php echo e($article->userVote(auth()->id())?->vote === -1 ? 'active-vote' : ''); ?>">Downvote</button>
                            </form>
                        </div>
                        <p class="vote-count" data-id="<?php echo e($article->id); ?>">
                            Votes: <?php echo e($article->userVotes->sum('vote')); ?>

                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p>No articles found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php echo e($articles->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const voteForms = document.querySelectorAll(".vote-form");

        voteForms.forEach(form => {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const url = form.action;
                const articleId = form.dataset.id;
                const voteCountElement = document.querySelector(`.vote-count[data-id="${articleId}"]`);
                const container = form.closest(".vote-container");
                const upvoteBtn = container.querySelector(".upvote-btn");
                const downvoteBtn = container.querySelector(".downvote-btn");

                try {
                    const response = await fetch(url, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    });
                    const data = await response.json();

                    // Update vote count
                    voteCountElement.textContent = `Votes: ${data.totalVotes}`;

                    // Update button states
                    upvoteBtn.classList.toggle("active-vote", data.userVote === 1);
                    downvoteBtn.classList.toggle("active-vote", data.userVote === -1);
                } catch (error) {
                    console.error("Vote submission failed:", error);
                    alert("An error occurred while processing your vote.");
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggleArticleForm");
    const articleForm = document.getElementById("articleForm");
    
    toggleButton.addEventListener("click", () => {
        const isHidden = articleForm.style.display === "none";
        
        if (isHidden) {
            articleForm.style.display = "block";
            setTimeout(() => {
                articleForm.classList.add("visible");
            }, 10);
        } else {
            articleForm.classList.remove("visible");
            setTimeout(() => {
                articleForm.style.display = "none";
            }, 300);
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\scienceLab\lab_website\resources\views/about.blade.php ENDPATH**/ ?>