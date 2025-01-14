@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/messages.css') }}" rel="stylesheet">
@endsection

@section('title', isset($receiver) ? "Chat with {$receiver->name}" : 'Messages')

@section('content')
<div class="messages-container">
    {{-- Chat List --}}
    @if (!isset($receiver))
        <div class="chat-list">
            <h2>Your Chats</h2>
            @if ($chats->isEmpty())
                <p>No active chats found. Start a new conversation!</p>
            @else
                <ul>
                    @foreach ($chats as $userId => $messages)
                        @php
                            $chatUser = $messages->first()->sender_id === auth()->id()
                                ? $messages->first()->receiver
                                : $messages->first()->sender;
                        @endphp
                        <li>
                            <a href="{{ route('messages.chat', ['receiver' => $chatUser->id]) }}" class="chat-link">
                                <img src="{{ asset('storage/' . $chatUser->profile_picture) }}" alt="{{ $chatUser->name }}" class="avatar">
                                <div class="chat-info">
                                    <span class="name">{{ $chatUser->name }}</span>
                                    <span class="last-message">{{ Str::limit($messages->last()->message, 30) }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @else
        {{-- Individual Chat --}}
        <div class="chat-messages">
            @forelse ($messages as $message)
                <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    <span class="sender">{{ $message->sender_id === auth()->id() ? 'You' : $message->sender->name }}</span>
                    <p>{{ $message->message }}</p>
                    <small class="timestamp">{{ $message->created_at->format('H:i') }}</small>
                </div>
            @empty
                <p>No messages yet. Start the conversation!</p>
            @endforelse
        </div>
        
        <form action="{{ route('messages.store') }}" method="POST" class="chat-form">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
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
    @endif
</div>
@push('scripts')
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
@endpush
@endsection
