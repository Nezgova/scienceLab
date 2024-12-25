// JavaScript to show the edit form when the "Edit" button is clicked
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        const articleId = e.target.getAttribute('data-article-id');
        const form = document.getElementById('edit-article-form-' + articleId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
});
