document.querySelectorAll('.vote-btn').forEach(button => {
    button.addEventListener('click', function () {
        const voteAction = this.dataset.voteAction; // 'up' or 'down'
        const articleId = this.dataset.articleId; // Article ID
        const voteCountElement = this.parentElement.querySelector('.vote-count'); // Locate vote count element

        // Disable the button to prevent multiple clicks
        this.disabled = true;

        // Send vote data via AJAX
        fetch('vote.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                article_id: articleId, // Extracted correctly
                vote: voteAction      // Extracted correctly
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    voteCountElement.textContent = data.newVoteCount;
                } else {
                    alert(data.message);
                }
                this.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
            });
        
    });
});
