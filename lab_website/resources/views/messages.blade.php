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
                <button type="submit">Send</button>
            </form>
        </div>
    @endif
</div>
@endsection
