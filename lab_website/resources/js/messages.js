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