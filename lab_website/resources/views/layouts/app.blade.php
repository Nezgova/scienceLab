<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">  <!-- Home CSS -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/LOGO.png') }}" type="image/x-icon">
<!-- Navbar CSS -->
        @yield('styles') <!-- profile.css or other styles will load here -->

        <title>@yield('title', 'Home')</title>
        
        <!-- CSRF Token for AJAX requests -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    
    <body>
        <!-- Include the Navbar Component -->
        <x-navbar />

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        <!-- Scripts Section -->
        <script src="{{ asset('js/app.js') }}" defer></script> <!-- Default JS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('/lab_website/resources/js/navbar.js') }}" defer></script>
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
        @yield('scripts') <!-- JavaScript from child views will load here -->
    </body>
</html>
